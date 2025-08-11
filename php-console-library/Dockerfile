FROM php:8.2-cli

WORKDIR /app

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# Сначала копируем ТОЛЬКО composer.json
COPY composer.json .

# Устанавливаем зависимости (если они есть)
RUN if [ -f "composer.json" ]; then composer install --no-dev --no-scripts; fi  

# Устанавливаем зависимости
RUN composer install --no-dev --no-scripts --no-autoloader

# Копируем остальные файлы
COPY . .

# Генерируем автозагрузку
RUN composer dump-autoload --optimize

# Устанавливаем права
RUN chmod +x /app/bin/console

ENTRYPOINT ["/app/bin/console"]