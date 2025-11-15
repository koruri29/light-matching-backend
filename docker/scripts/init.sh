#!/bin/bash
set -e

echo "Starting init.sh..."

DB_HOST=${DB_HOST:-laravel-db}
DB_PORT=${DB_PORT:-5432}
DB_USER=${DB_USERNAME:-laravel}
DB_PASS=${DB_PASSWORD:-laravelpass}
DB_NAME=${DB_DATABASE:-laravel}

# DB起動待機（最大60秒）
TRIES=0
MAX_TRIES=30
until pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USER; do
  TRIES=$((TRIES+1))
  if [ $TRIES -ge $MAX_TRIES ]; then
    echo "Database not ready after $((MAX_TRIES*2)) seconds. Exiting."
    exit 1
  fi
  echo "Waiting for database... ($TRIES/$MAX_TRIES)"
  sleep 2
done

echo "Database is ready!"

# マイグレーション & シーディング
php artisan migrate --force
php artisan db:seed --force

# PHP Built-in server で起動（テスト用）
php artisan serve --host=0.0.0.0 --port=8000
