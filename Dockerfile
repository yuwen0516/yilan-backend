FROM php:8.2-apache

# 啟用 Apache mod_rewrite（如果你有用 .htaccess）
RUN a2enmod rewrite

# 複製所有檔案到 Apache 根目錄
COPY . /var/www/html/

# 設定資料夾權限（可選）
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
