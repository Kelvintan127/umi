#!/usr/bin/env bash
set -uo pipefail
cd /opt/data/dev/umi
sed -i 's/^MAIL_PORT=.*/MAIL_PORT=2527/' .env
/opt/data/dev/bin/php artisan config:clear >/dev/null
echo "port now:"; grep '^MAIL_PORT=' .env
