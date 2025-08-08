# Simple Laravel POC Dockerfile
FROM php:8.3-cli
WORKDIR /var/www/html

# System deps
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libicu-dev libonig-dev libpq-dev default-mysql-client \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Redis extension (optional but helpful)
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy source
COPY . /var/www/html

# Install PHP deps (optimize for dev speed)
RUN if [ -f composer.json ]; then \
            php -d memory_limit=-1 /usr/bin/composer install --no-interaction --prefer-dist; \
        fi

# Laravel permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
  && chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port for artisan serve
EXPOSE 8000

# Entrypoint
COPY ./.docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
