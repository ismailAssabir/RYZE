# استخدم نسخة PHP رسمية
FROM php:8.3-apache

# تثبيت الإضافات المطلوبة
RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# إعداد المجلد الرئيسي
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . .

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تغيير مسار الـ Apache ليشير إلى public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# فتح المنفذ
EXPOSE 80