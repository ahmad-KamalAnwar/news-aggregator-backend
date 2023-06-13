#!/bin/bash
set -o errexit -o nounset -o pipefail

# only intended to run in development when using volume mounting
install_dependencies() {
  # install composer dependencies
  echo "Installing composer dependencies..."
  composer install --working-dir=/var/www/html
}

initialize_system() {
  php artisan migrate

  # Clear caches
  composer dump-autoload
  php artisan config:clear
  php artisan cache:clear

  if [ "$APP_ENV" == "local" ] && [ "$ENABLE_XDEBUG" == 1 ]; then
    cp deploy/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
  fi
}

if [ "$APP_ENV" == "local" ]; then
  # TODO Figure out some way to run cron through nginx user
  echo "0 * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" > /etc/crontabs/root
  crond
  /sbin/crons/import-articles.sh

fi

# Fix .composer directory ownership - needed when PUID and PGID are present
if [ ! -z "${PUID-}" ]; then
  echo "Fixing .composer ownership ownership ..."
  chown -Rf nginx.nginx /var/cache/nginx/.composer
  chown -Rf nginx.nginx /usr/local/etc/php/conf.d
  echo "Installing dependencies"
  su nginx -s /bin/sh -c "$(declare -f install_dependencies); install_dependencies"
fi

# Initialize system as nginx user
su nginx -s /bin/sh -c "$(declare -f initialize_system); initialize_system"
