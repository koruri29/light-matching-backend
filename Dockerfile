FROM php:8.2-fpm

WORKDIR /var/www/html

# 必要なパッケージ + PostgreSQL クライアント
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip curl \
    # postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# app コピー
COPY . .

# scripts 実行権限
# RUN chmod +x docker/scripts/init.sh
