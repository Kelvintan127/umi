# UMI Stamping — Deployment Runbook

Target: `umistamping.com`, Laravel 12 + Inertia + React, served by PHP-FPM behind
nginx, with the Inertia SSR renderer as a supervised sidecar process.

> **Nothing in this document authorises a production change.** Deploying requires
> explicit approval *and* a confirmed, tested backup. See §6 and §8.

---

## 1. Build artifacts

Built locally, not on the server. `public/build` and `bootstrap/ssr` are
gitignored and produced by the build step.

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci
npm run build        # writes public/build/{manifest.json,assets/*}
npm run ssr          # writes bootstrap/ssr/ssr.js + ssr-manifest.json
```

`npm run ssr` is mandatory when `config/inertia.php` has `ssr.enabled = true`.
Without the bundle, `@inertiaHead` renders nothing: pages still work, but the
first byte carries no title, description, canonical or hreflang — the SEO
regression that SSR was enabled to fix.

Artifacts to transfer: `public/build/`, `bootstrap/ssr/`, `vendor/`,
`app/`, `bootstrap/`, `config/`, `database/`, `lang/`, `public/` (excluding
`public/build`), `resources/`, `routes/`, `storage/` (structure only), `tools/`,
`artisan`, `composer.json`, `composer.lock`, `package.json`, `package-lock.json`.

Do not transfer: `.env`, `node_modules/`, `database/*.sqlite`, `storage/logs/*`,
`tests/`, `.git/`.

---

## 2. Environment variables

Full list in `.env.example`. The values that decide behaviour:

| Variable | Required | Notes |
|---|---|---|
| `APP_KEY` | yes | `php artisan key:generate`. Rotating it invalidates sessions and encrypted payloads. |
| `APP_ENV` | yes | `production`. `local` in production disables error recovery and leaks config in stack traces. |
| `APP_DEBUG` | yes | `false`. **`true` prints the full `.env` on any uncaught exception.** |
| `APP_URL` | yes | `https://www.umistamping.com`. Every canonical, hreflang, sitemap and `og:url` is built from it. |
| `APP_TIMEZONE` | no | `UTC` unless the company wants Asia/Jakarta. |
| `DB_*` | yes | See §5. |
| `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION` | yes | Provider credentials — **not present in this repo**. |
| `MAIL_FROM_ADDRESS` | yes | Must be a mailbox the provider will send as, or mail is rejected/spam-foldered. |
| `MAIL_INQUIRY_TO` | yes | Where inquiries go. Empty is tolerated: inquiries are still stored and `queued=false` is reported, but nothing is emailed. |
| `MAIL_INQUIRY_ACKNOWLEDGE` | no | `true` sends the enquirer a confirmation in their own locale. |
| `INERTIA_SSR_URL` | no | Default `http://127.0.0.1:13714`. |
| `SESSION_DRIVER` | yes | `database` (default) or `redis`. `array` loses sessions between requests. |
| `SESSION_SECURE_COOKIE` | yes | `true` on HTTPS. |

Never commit `.env`. It is gitignored — verify with `git check-ignore -v .env`
before every deploy.

---

## 3. Web server and PHP

PHP **8.2+** (built and tested on 8.4.8). Required extensions: `pdo_sqlite` or
`pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`,
`curl`. `dns_get_record` (part of the core `standard` extension) is used by
`App\Rules\DeliverableEmail`, and must not be in `disable_functions`: with it
disabled the rule treats every domain as unverifiable and accepts everything —
spam gets through silently.

nginx document root **must** be `public/`:

```nginx
server {
    listen 443 ssl http2;
    server_name umistamping.com www.umistamping.com;
    root /srv/umi/public;          # NOT the project root

    index index.php;
    charset utf-8;
    client_max_body_size 12m;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 60s;
    }

    # Immutable build output: the filenames are content-hashed.
    location /build/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    location ~* \.(?:jpg|jpeg|png|webp|svg|mp4|ico|woff2)$ {
        expires 30d;
        add_header Cache-Control "public";
        access_log off;
    }

    # No dotfiles, no .env, no SQLite, whatever the request path says.
    location ~ /\.(?!well-known) { deny all; }
    location ~* \.(?:env|sqlite|sqlite3|log|md)$ { deny all; }
}
```

Redirect HTTP to HTTPS and pick **one** canonical hostname (apex or `www`);
canonical tags use `APP_URL`, so a mismatch splits SEO signal.

---

## 4. Inertia SSR renderer

A long-running Node process on `127.0.0.1:13714`, supervised so it restarts on
crash and starts on boot:

```ini
# /etc/systemd/system/umi-ssr.service
[Unit]
Description=UMI Inertia SSR renderer
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/srv/umi
ExecStart=/usr/bin/node bootstrap/ssr/ssr.js
Restart=always
RestartSec=3
Environment=NODE_ENV=production

[Install]
WantedBy=multi-user.target
```

```bash
systemctl enable --now umi-ssr
curl -sf http://127.0.0.1:13714/health    # must return 200
```

**Restart it after every deploy.** `bootstrap/ssr/ssr.js` is read once at
startup; a running renderer keeps serving the old bundle and silently renders
stale markup — this bit us during development.

The renderer is not a hard dependency: if it is down, Inertia falls back to
client-side rendering. The site stays up and the head degrades. Treat a down
renderer as an SEO incident, not an outage.

---

## 5. Database

Default is SQLite (`database/database.sqlite`) — adequate for a brochure site
with a low-volume contact form. **Do not place the SQLite file on NFS**: SQLite
locks do not work reliably over network filesystems and the database will
corrupt. If the project moves to MySQL/MariaDB:

```bash
php artisan migrate --force          # --force is required when APP_ENV=production
php artisan db:seed --force          # only if seeders exist and are intended
```

Both `inquiries` and `sessions`/`cache` tables (if `SESSION_DRIVER=database`)
are created by migrations. Migrations are additive; this release adds one table
(`inquiries`).

Permissions — the web user needs write access to `storage/` and
`bootstrap/cache/`, and to the SQLite file *and its directory* (SQLite creates
journal files alongside it):

```bash
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database
```

Stop queue workers before migrating, restart after. Cache the config only when
`.env` is final — `config:cache` bakes `.env` in, and later `.env` edits appear
to do nothing until it is cleared:

```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## 6. Backup and rollback

**Take the backup before touching the live site, and verify the restore path.
An untested backup is not a backup.**

```bash
STAMP=$(date -u +%Y%m%dT%H%M%SZ)
mkdir -p /mnt/truenas-umi/backups/umi/$STAMP

# 1. Database (SQLite: use .backup; a plain cp of a live DB can be torn)
sqlite3 /srv/umi/database/database.sqlite ".backup /mnt/truenas-umi/backups/umi/$STAMP/database.sqlite"
# MySQL:  mysqldump --single-transaction umi | gzip > .../umi-$STAMP.sql.gz

# 2. Uploaded/user data (storage/app, if any) — not the log or cache dirs
rsync -a --exclude='logs/' --exclude='framework/cache/' /srv/umi/storage/ /mnt/truenas-umi/backups/umi/$STAMP/storage/

# 3. Record what is live, so a rollback has a target
git -C /srv/umi rev-parse HEAD > /mnt/truenas-umi/backups/umi/$STAMP/REVISION
php /srv/umi/artisan about --only=environment > /mnt/truenas-umi/backups/umi/$STAMP/environment.txt
```

Verify the backup restores before relying on it:

```bash
sqlite3 /mnt/truenas-umi/backups/umi/$STAMP/database.sqlite "PRAGMA integrity_check; select count(*) from inquiries;"
```

Rollback, code only (no migration in this release):

```bash
cd /srv/umi
git checkout <previous-revision-from-REVISION-file>
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci && npm run build && npm run ssr
php artisan migrate --force          # no-op if the schema did not change
php artisan config:cache route:cache view:cache
systemctl restart umi-ssr php8.4-fpm
```

Rollback including data: stop PHP-FPM, restore the database file, fix ownership,
start PHP-FPM. Restoring the database loses inquiries submitted since the backup
— export them first if that matters.

Rollback a migration: `php artisan migrate:rollback --step=1 --force`. This
drops `inquiries` and its data. Only correct if the table was created by the
change being rolled back.

---

## 7. Monitoring and logging

- Application log: `storage/logs/laravel.log` (daily rotation). Send to the
  central log host or configure a channel — a log nobody reads is not monitoring.
- Watch for these, emitted by name:
  - `contact.mail_failed` — the inquiry was stored but SMTP rejected it. Every
    occurrence is a lead that nobody was emailed about.
  - `contact.mail_not_configured` — `MAIL_INQUIRY_TO` is empty. Inquiries are
    landing in the database with no notification.
  - `contact.email_dns_unavailable` — a burst means the resolver is down and the
    email rule is accepting everything.
  - `contact.rejected` — expect noise; a large spike means a bot campaign.
- Alert on: 5xx rate, `curl -sf http://127.0.0.1:13714/health` failing, disk
  space (SQLite and logs grow), and PHP-FPM pool saturation.
- Uptime checks: `/en` (200), `/sitemap.xml` (200), `/en/contact`, and one
  404 path that must return 404.
- `php artisan down --secret=<token>` for maintenance; the token bypasses the
  maintenance page for verification.

---

## 8. SSL and domain checklist

- [ ] Certificate covers both `umistamping.com` and `www.umistamping.com`, or
      one of them redirects to the other at the nginx level.
- [ ] Certificate is valid for at least 30 more days; auto-renewal is armed.
- [ ] HTTP → HTTPS permanent redirect, including for `/build/*`.
- [ ] HSTS enabled (`max-age=31536000; includeSubDomains`) **only** once HTTPS
      is confirmed working on every subdomain — HSTS is hard to undo.
- [ ] `APP_URL` equals the canonical scheme+host exactly (no trailing slash).
- [ ] `SESSION_SECURE_COOKIE=true`, `SESSION_SAME_SITE=lax`.
- [ ] `https://www.umistamping.com/sitemap.xml` and `/robots.txt` return 200 and
      the sitemap lists only canonical URLs.
- [ ] Existing production DNS, mail (MX/SPF/DKIM/DMARC) records untouched.
- [ ] Old URL → new URL redirect map in place **before** DNS changes go live.

---

## 9. Post-deployment smoke tests

Run these against the live host after deploying, in this order. A 200 is not
sufficient — check the content.

```bash
BASE=https://www.umistamping.com

# 1. Every public page returns 200 AND real content (not an empty shell)
for p in "" /about /company-profile /certifications /policy /capabilities \
         /products /products/battery-contacts /products/wire-harnessing \
         /products/ods-dvd-drive /products/mechanical-assembly \
         /products/electrical-metal-parts /facilities \
         /facilities/production-machines /facilities/supporting-machines \
         /facilities/tools-design-storage /facilities/measurement-equipment \
         /metal-part-users /industries /quality /gallery /news /contact \
         /privacy /terms; do
  body=$(curl -sS "$BASE/en$p")
  code=$(curl -sS -o /dev/null -w '%{http_code}' "$BASE/en$p")
  words=$(printf '%s' "$body" | sed 's/<[^>]*>/ /g' | wc -w)
  printf '%-46s %s  %s words\n' "/en$p" "$code" "$words"
done
```

Every line must be 200 and comfortably above 100 words. A 200 with ~20 words
means SSR is down and only the shell is being served.

```bash
# 2. SSR is live: the first byte must carry the head
curl -sS "$BASE/en" | grep -c '<title'                  # expect 1
curl -sS "$BASE/en" | grep -o 'rel="canonical"[^>]*'    # expect a real URL
curl -sS -o /dev/null -w '%{http_code}\n' http://127.0.0.1:13714/health  # 200

# 3. Locale policy is still fail-closed (drafts must NOT be served)
for u in /id /zh /id/about /zh/products; do
  curl -sS -o /dev/null -w "$u -> %{http_code} %{redirect_url}\n" "$BASE$u"
done        # expect 302 to the /en/ equivalent

# 4. Email must NOT resolve to itself; /en only is the published locale
curl -sS "$BASE/sitemap.xml" | grep -c '<loc>'          # 25
curl -sS "$BASE/robots.txt"

# 5. 404 handling and security headers
curl -sS -o /dev/null -w '%{http_code}\n' "$BASE/en/no-such-page"   # 404
curl -sS -o /dev/null -w '%{http_code}\n' "$BASE/.env"              # 403/404
curl -sS -o /dev/null -w '%{http_code}\n' "$BASE/database/database.sqlite"  # 403/404

# 6. Contact form, end to end (this is the one that matters)
#    Submit through a real browser at $BASE/en/contact, then confirm:
#      - the thank-you panel appears
#      - the row landed in the database
#      - the notification email arrived at MAIL_INQUIRY_TO
#      - the acknowledgement arrived at the address you submitted
```

Check the log after the smoke test: a `contact.mail_failed` or
`contact.mail_not_configured` line means the form "worked" while silently
failing to notify anyone.

Finally, load one page in a real browser and confirm: fonts and images load, the
hero video plays, the mobile menu opens and closes, no horizontal scrollbar, and
the contact form submits.

---

## 10. Release states

Do not conflate these. Each is a separate gate with separate evidence.

1. **IMPLEMENTATION COMPLETE** — code written, tests green, build reproducible.
2. **STAGING ACCEPTED** — deployed to an isolated staging host and verified there
   with a real browser.
3. **PRODUCTION RELEASE APPROVED** — explicit owner approval, backup taken and
   restore verified, rollback documented.
4. **PRODUCTION DEPLOYED AND VERIFIED** — the smoke tests in §9 have run against
   the live host and passed, with their output recorded.

Staging success is **not** evidence for production. The most common way to
announce a broken release is to promote staging without re-running §9 against
the production host.
