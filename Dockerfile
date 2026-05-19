FROM php:8.3-apache

# تثبيت الحزم المطلوبة
RUN apt-get update && apt-get install -y libsqlite3-dev git unzip \
    && docker-php-ext-install pdo pdo_sqlite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد العمل
WORKDIR /var/www/html

# نسخ ملفات الإعدادات وتثبيت الحزم
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# نسخ كل الكود (هنا نتأكد من النسخ)
COPY . .

# ⚠️ الخطوة الأهم: إجبار Apache على قراءة المجلد الصحيح
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ضبط الصلاحيات بشكل صارم
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# فحص نهائي أثناء البناء (ستظهر هذه النتائج في Build Logs في Railway)
RUN ls -R /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]