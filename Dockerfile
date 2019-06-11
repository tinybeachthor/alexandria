FROM webdevops/php-apache:ubuntu-16.04

# Production context
ENV \
  PROVISION_CONTEXT="production" \
  TYPO3_CONTEXT="Production/Docker" \
  SYMFONY_ENV="prod" \
  SYMFONY_DEBUG="0" \
  CAKE_ENV="prod" \
  YII_ENVIRONMENT="Production"
# Paths to app files
ENV \
  APP_ROOT="/app/" \
  WEB_DOCUMENT_ROOT="/app/public/" \
  WEB_DOCUMENT_INDEX="index.php" \
  CLI_SCRIPT="php /app/src/index.php" \
  STORAGE_ROOT="/data/"

# Deploy scripts/configurations
COPY etc/ /opt/docker/etc/

RUN ln -sf /opt/docker/etc/cron/crontab /etc/cron.d/docker-boilerplate \
    && chmod 0644 /opt/docker/etc/cron/crontab \
    && echo >> /opt/docker/etc/cron/crontab \
    && ln -sf /opt/docker/etc/php/production.ini /opt/docker/etc/php/php.ini

# Configure volume/workdir
WORKDIR /app/

# Install dependencies
COPY app/composer.json app/composer.lock /app/
RUN composer install

# Copy app files
COPY app/ /app/
