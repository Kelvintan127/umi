# Staging Deployment Runbook

Verified staging instance, running from this container. Nothing here touches production.

## What is running

| Component | Dev | Staging |
|---|---|---|
| App | `127.0.0.1:8931` | `127.0.0.1:8941` |
| SSR renderer | `127.0.0.1:13714` | `127.0.0.1:13724` |
| Checkout | `/opt/data/dev/umi` | `/opt/data/dev/umi-staging` |
| Database | `/opt/data/dev/umi/database/database.sqlite` | `/opt/data/dev/umi-staging/database/database.sqlite` |
| Mail | `log` | `log`, no recipient |

Staging is a separate clone of `develop`, a separate SQLite file and separate
ports. It shares no writable state with development, so a staging migration
cannot touch development data.

## Isolation rules

Staging uses these deliberately, and they must not be "fixed" to match production:

- `MAIL_INQUIRY_TO=` empty. Inquiries persist and the site reports honestly that
  nobody was notified. Staging must never email a real customer or a real
  `office@umistamping.com`.
- `MAIL_INQUIRY_ACKNOWLEDGE=false`. No acknowledgement goes to a test address.
- `MAIL_MAILER=log`. Messages land in `storage/logs/laravel.log`.
- Separate `APP_KEY`. Sessions from one instance are not valid on the other.
- `APP_DEBUG=false`, so staging exercises the production error path.
- `APP_ENV=staging`.

## Bring staging up from scratch

```bash
cd /opt/data/dev
git clone --branch develop /opt/data/dev/umi umi-staging
cd umi-staging
/opt/data/dev/bin/php /opt/data/dev/bin/composer.phar install --no-interaction
touch database/database.sqlite
# write .env (see below), then:
/opt/data/dev/bin/php artisan key:generate --force
/opt/data/dev/bin/php artisan migrate --force
npm ci
npm run build
npm run ssr
/opt/data/dev/bin/php artisan optimize
```

Two processes, both must stay running:

```bash
INERTIA_SSR_PORT=13724 INERTIA_SSR_URL=http://127.0.0.1:13724 \
  /opt/data/dev/bin/php artisan inertia:start-ssr &
/opt/data/dev/bin/php artisan serve --host=127.0.0.1 --port=8941 &
```

### Pitfall: `.env` gets overwritten

`composer install` on a clean checkout runs `post-root-package-install`, which
copies `.env.example` over nothing but a missing `.env`. More importantly, any
`write_file` to `.env` is refused when the file exists and has not been read in
this session — the write silently does not happen and you keep testing the old
config. Write it through a shell redirect and then confirm with
`grep -E '^(APP_ENV|APP_URL)=' .env` before trusting the instance.

### Pitfall: SSR port

`artisan inertia:start-ssr` has no `--port` flag. The port comes from
`INERTIA_SSR_PORT`, read in `resources/js/ssr.tsx`. Passing `--port` produces an
`Unknown option` fatal in the log and no listening socket. Confirm with
`curl -s http://127.0.0.1:13724/health` returning `{"status":"OK"}`.

## Health checks

```bash
curl -s -o /dev/null -w 'app=%{http_code}\n'  http://127.0.0.1:8941/en      # expect 200
curl -s http://127.0.0.1:13724/health                                       # expect status OK
```

A 200 from the app alone is not proof: without the renderer the first byte is an
empty `<div id="app">`. Check the server is actually rendering:

```bash
curl -s http://127.0.0.1:8941/en | grep -c '<h1'
```

## Verification performed

- 20 English pages return 200 with one `<h1>` each, real body text, no broken
  images and no image missing `alt`.
- Canonical and hreflang absolute URLs point at `127.0.0.1:8941`.
- Unsigned locales redirect: `/id`, `/zh`, `/id/about`, `/zh/products`,
  `/id/products/battery-contacts` all land on the `/en` equivalent.
- Contact form persists to the staging database with `mail_sent_at` null and no
  message delivered anywhere.

## Rollback

Staging is disposable; the rollback is to destroy and rebuild.

```bash
pkill -f 'umi-staging.*artisan serve'
pkill -f 'umi-staging.*start-ssr'
rm -rf /opt/data/dev/umi-staging
# then re-run "Bring staging up from scratch" at the previous known-good tag
```

Because the database only ever holds test inquiries, no dump is needed. If a
deployment went wrong in a way that mattered, redeploy the previous commit:

```bash
cd /opt/data/dev/umi-staging && git checkout <previous-sha> && \
  /opt/data/dev/bin/php artisan migrate --force && npm run build && npm run ssr && \
  /opt/data/dev/bin/php artisan optimize
```

Development is unaffected by any staging rollback — different directory,
database, ports and key.

## What this is not

This is not a deployment to a host. `10.0.2.1` answers on 22/80/443/3000/8000
but public-key authentication is refused for `hermes`, `root`, `ubuntu` and
`deploy`, and there is no Docker socket in this container. There is no staging
vhost, no TLS termination and no DNS. Treat the URLs above as reachable only
from inside this container until host access exists.

Production deployment to `umistamping.com` remains unauthorized and unstarted.
