# Production Host Deployment Procedure

For a host operator with root on the target VM. Written because the agent has no
privileged host access: SSH public-key authentication to `10.0.2.1` is refused for
the available key, and there is no Docker socket or shared filesystem in the
agent's container. See "Host access status" at the end.

**Do not run this against the live `umistamping.com` deployment.** This describes
a new isolated staging vhost on the same host, on a separate domain, database and
application key. Cutover of the live site is a separate, separately authorised
procedure.

## Prerequisites

- Ubuntu 24.04 VM (the host reports OpenSSH 9.6p1 Ubuntu-3ubuntu13.20)
- Root or sudo
- A domain pointing at the host for staging, e.g. `staging.umistamping.com`
- PHP 8.4 with `pdo_sqlite`/`pdo_mysql`, nginx, Node 20+, git

## Host access status

```
$ ssh -o BatchMode=yes -i /opt/data/host-ssh/id_ed25519 hermes@10.0.2.1
hermes@10.0.2.1: Permission denied (publickey)

Server offered: publickey only
Key offered:    ED25519 SHA256:/mrAgrUVehN1to/jU3/gWpIfTDMoEr3/szM1a+LZCqk
Result:         key not present in that account's authorized_keys
```

The key is valid and matching its `.pub`. The refusal is an `authorized_keys`
absence, not a key or protocol problem. Adding the key, or using an account whose
`authorized_keys` already holds it, is the host operator's step.

```
# On the host, as the deployment user:
install -d -m 700 ~/.ssh
echo 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIPza... umi-deploy' >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

Confirm before handing back: `ssh -i <key> <user>@10.0.2.1 'echo OK'` returns `OK`.

## 1. Create the staging instance

```bash
adduser --system --group --home /srv/umi-staging umistaging
su -s /bin/bash umistaging

git clone --branch develop https://github.com/Kelvintan127/umi.git /srv/umi-staging/app
cd /srv/umi-staging/app
git checkout dee13b9            # pin the reviewed commit; do not track branch HEAD
composer install --no-dev --no-interaction --optimize-autoloader
```

## 2. Isolated configuration

**Independent database and APP_KEY are the point of this section.** Sharing either
with production means a staging migration or a staging session can reach live data.

```bash
cp .env.example .env
```

Edit `/srv/umi-staging/app/.env`:

```dotenv
APP_NAME="UMI Stamping (staging)"
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.umistamping.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=umi_staging
DB_USERNAME=umi_staging
DB_PASSWORD=<generate, store in secret manager>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Staging must never email a real customer or the real office inbox.
MAIL_MAILER=log
MAIL_INQUIRY_TO=
MAIL_INQUIRY_ACKNOWLEDGE=false

INERTIA_SSR_URL=http://127.0.0.1:13734
```

```bash
# Distinct APP_KEY — never copy production's. Two instances sharing a key can
# forge each other's encrypted payloads and sessions.
php artisan key:generate --force

# Distinct database, created fresh.
mysql -e "CREATE DATABASE umi_staging CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER 'umi_staging'@'127.0.0.1' IDENTIFIED BY '<password>';"
mysql -e "GRANT ALL ON umi_staging.* TO 'umi_staging'@'127.0.0.1';"

php artisan migrate --force
```

Never point staging migrations at the production database. Confirm before
migrating: `php artisan db:show` must name `umi_staging`.

## 3. Build

```bash
npm ci
npm run build
npm run ssr
php artisan optimize
```

## 4. Process supervision

Two long-running processes: PHP-FPM (serves the app) and the SSR renderer. The
renderer is not optional — without it the first byte is an empty `<div id="app">`
and the SEO metadata does not exist.

`/etc/systemd/system/umi-staging-ssr.service`:

```ini
[Unit]
Description=UMI Staging Inertia SSR renderer
After=network.target

[Service]
User=umistaging
WorkingDirectory=/srv/umi-staging/app
Environment=INERTIA_SSR_PORT=13734
Environment=INERTIA_SSR_URL=http://127.0.0.1:13734
ExecStart=/usr/bin/php artisan inertia:start-ssr
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
```

```bash
systemctl daemon-reload
systemctl enable --now umi-staging-ssr
```

## 5. nginx and TLS

```nginx
server {
    listen 443 ssl http2;
    server_name staging.umistamping.com;

    root /srv/umi-staging/app/public;
    index index.php;

    ssl_certificate     /etc/letsencrypt/live/staging.umistamping.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/staging.umistamping.com/privkey.pem;

    add_header Strict-Transport-Security "max-age=31536000" always;

    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
    }
}

server {
    listen 80;
    server_name staging.umistamping.com;
    return 301 https://$host$request_uri;
}
```

```bash
certbot --nginx -d staging.umistamping.com
nginx -t && systemctl reload nginx
```

## 6. Health checks

```bash
# App responds
curl -fsS -o /dev/null -w '%{http_code}\n' https://staging.umistamping.com/en    # 200

# SSR renderer alive
curl -fsS http://127.0.0.1:13734/health                                          # {"status":"OK",...}

# Server is actually rendering, not shipping an empty shell
curl -fsS https://staging.umistamping.com/en | grep -c '<h1'                     # >= 1

# Locale policy fails closed
curl -sI https://staging.umistamping.com/id | grep -i '^location'                # .../en
```

A 200 on its own is not proof. The `<h1` check is what distinguishes a rendered
page from an empty app shell.

## 7. Rollback

```bash
cd /srv/umi-staging/app
git checkout <previous-good-sha>
composer install --no-dev -o
npm ci && npm run build && npm run ssr
php artisan migrate --force     # migrations are additive; no rollback needed to revert code
php artisan optimize
systemctl restart umi-staging-ssr
```

If a migration must be undone:

```bash
php artisan migrate:rollback --step=1
```

Production rollback is out of scope here and must be prepared separately before
any production release is authorised. Note that a production rollback needs a
verified database backup taken immediately before deployment — a code rollback
does not restore data.

## 8. What this procedure does not claim

- That staging is deployed. It is not; the host refuses the key.
- That the live site is touched. It is not.
- That a production release is approved. It is not.

Production deployment requires explicit authorisation plus a tested backup and a
rehearsed rollback. Neither exists yet.
