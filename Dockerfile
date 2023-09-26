# Use a imagem PHP oficial como base
FROM php:8.2.10-cli

# Instale as extensões do PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Comando para executar o servidor web PHP embutido
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html/backend"]