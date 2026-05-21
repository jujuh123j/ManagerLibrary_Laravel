#!/bin/sh
set -e

# Change into the project directory
cd /var/www

# Install Composer dependencies if vendor folder does not exist
if [ ! -d "vendor" ]; then
    echo "vendor directory not found. Installing dependencies via Composer..."
    composer install --no-interaction --optimize-autoloader
fi

# Set up environment file
if [ ! -f ".env" ]; then
    echo ".env file not found. Copying .env.example..."
    cp .env.example .env
    php artisan key:generate --force
fi

# Wait for MySQL database container to be ready
echo "Waiting for the MySQL database container ('db') to be ready..."
until mysqladmin ping -h"db" -u"root" -p"root" --skip-ssl --silent; do
    echo "Database is not ready yet. Retrying in 2 seconds..."
    sleep 2
done

echo "Database is ready!"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Set correct permissions for storage, bootstrap/cache, and public directory
echo "Configuring permissions for storage, bootstrap/cache, and public..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chmod -R 755 /var/www/public

# Run the passed command (usually php-fpm)
echo "Starting application server..."
exec "$@"
