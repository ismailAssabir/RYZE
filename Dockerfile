FROM php:8.3-apache

RUN apt-get update && apt-get install -y libsqlite3-dev git unzip \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

# إصلاح مسار Apache بشكل قطعي
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html

# بدلاً من CMD الافتراضي، دعنا نستخدم هذا:
CMD ["sh", "-c", "php artisan config:clear && php artisan cache:clear && apache2-foreground"]