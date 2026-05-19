FROM php:8.3-apache

# تثبيت الحزم اللازمة
RUN apt-get update && apt-get install -y libsqlite3-dev git unzip
RUN docker-php-ext-install pdo pdo_sqlite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ ملفات التعريف أولاً
COPY composer.json composer.lock ./

# تثبيت الحزم
RUN composer install --no-dev --optimize-autoloader

# نسخ كل شيء من المجلد الحالي إلى الحاوية
COPY . .

# تصحيح الصلاحيات (هذا هو الجزء الذي يحل مشكلة الـ Permission/Access)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# تأكيد وجود الملفات (لأغراض التصحيح)
RUN ls -la /var/www/html

# إعداد Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

CMD ["apache2-foreground"]