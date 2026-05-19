FROM php:8.3-apache

# تثبيت الإضافات الأساسية
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite

# إعداد العمل
WORKDIR /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات التثبيت أولاً (للاستفادة من الـ Docker Cache)
COPY composer.json composer.lock ./

# تثبيت المكتبات بدون سكربتات لتجنب أخطاء الإعداد أثناء البناء
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# نسخ كامل كود المصدر
COPY . .

# إصلاح الصلاحيات (مهم جداً)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ضبط مسار Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# إضافة أمر التشغيل الافتراضي
CMD ["apache2-foreground"]