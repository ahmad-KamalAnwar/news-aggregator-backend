#!/bin/bash
set -o errexit -o nounset -o pipefail

echo "Starting import:articles Cron"

# */30 * * * * (Every thirty minutes)
cronlock /usr/local/bin/php /var/www/html/artisan import:articles

echo "Finished import:articles Cron"
