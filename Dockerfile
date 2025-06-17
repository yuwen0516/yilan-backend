FROM php:8.2-apache

# 安裝 mysqli 套件
RUN docker-php-ext-install mysqli

# 啟用 Apache mod_rewrite（如果有 .htaccess）
RUN a2enmod rewrite

# 複製檔案到 Apache 根目錄
COPY . /var/www/html/

# 設定檔案權限（可選）
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
