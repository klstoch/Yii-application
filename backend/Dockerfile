FROM yiisoftware/yii2-php:8.2-apache

RUN pecl install redis \
    && docker-php-ext-enable redis

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/backend/web|g' /etc/apache2/sites-available/000-default.conf
