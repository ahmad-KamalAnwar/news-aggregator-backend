FROM richarvey/nginx-php-fpm:1.10.1

MAINTAINER Ahmad Kamal Anwar <ahmadkamalanwar.it@gmail.com>

# Build arguments
ARG APP_ENV=prod

# Environment variable defaults
ENV WEBROOT="/var/www/html/public"
ENV APP_ENV=$APP_ENV
ENV ERRORS=0
ENV SKIP_COMPOSER=1
ENV SKIP_CHOWN=1
ENV RUN_SCRIPTS=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV BUILD_ON_RUN=false

# Copy php-fpm conf
COPY deploy/www.conf /usr/local/etc/php-fpm.d/www.conf

# Change ownership of app dir
RUN chown -Rf nginx.nginx /var/www/html/

USER nginx

RUN mkdir /var/cache/nginx/.composer && chown nginx:nginx /var/cache/nginx/.composer

COPY --chown=nginx:nginx . /var/www/html/

# Install build dependencies
RUN if [ "$APP_ENV" = "dev" ] ; then \
        composer global require hirak/prestissimo && \
        composer install --working-dir=/var/www/html \
    ; else \
        composer global require hirak/prestissimo && \
        composer install --no-dev --working-dir=/var/www/html \
    ; fi

USER root

WORKDIR "/var/www/html"

CMD ["/start.sh"]
