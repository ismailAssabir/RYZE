# استخدم نسخة PHP مع Apache
FROM php:8.3-apache

# تثبيت متطلبات النظام وComposer
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite

# تثبيت Composer من الصورة الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد المجلد الرئيسي
WORKDIR /var/www/html

# نسخ ملفات Composer أولاً لتسريع عملية البناء (Cache)
COPY composer.json composer.lock* ./

# تثبيت المكتبات (هذا هو السطر المفقود)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# نسخ باقي ملفات المشروع
COPY . .

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تغيير مسار Apache ليشير إلى public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80