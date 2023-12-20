# Dockerfile 2
# Stage 1: PHP Builder
FROM php:8.2-fpm-alpine as php-builder

ENV APP_NAME=Fresheats-App
ENV APP_ENV=production
ENV APP_KEY=base64:4rXNus8IH9iOawDoZDaXjDHbXWcZVFgjmg/2ZaenEMk=
ENV APP_DEBUG=false

ENV DB_CONNECTION=mysql
ENV DB_HOST=35.224.132.138
ENV DB_PORT=3306
ENV DB_DATABASE=fresheats-db
ENV DB_USERNAME=root
ENV DB_PASSWORD=admin12345

ENV MIDTRANS_MERCHAT_ID=G360722397
ENV MIDTRANS_SERVER_KEY="SB-Mid-server-u6JeAuJlPcR5ffeOnDcPwnj1"
ENV MIDTRANS_CLIENT_KEY="SB-Mid-client-WbqjS8Z5FDV-bQmt"
ENV MIDTRANS_IS_PRODUCTION=false
ENV MIDTRANS_IS_SANITIZED=true
ENV MIDTRANS_IS_3DS=true

# Install necessary dependencies
RUN apk add --no-cache nginx

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /run/nginx

# Set up PHP extensions and settings
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set up the working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set ownership
RUN chown -R www-data:www-data /app

# Stage 2: Frontend Builder
FROM node:14 as front-builder

WORKDIR /app

# Copy only necessary files
COPY --from=php-builder /app /app

# Install Node.js dependencies
RUN npm install

# Build the frontend assets
RUN npm run build

# Stage 3: Final Image
FROM php:8.2-fpm-alpine

# Copy the necessary files from the PHP Builder and Frontend Builder stages
COPY --from=php-builder /app /app
COPY --from=front-builder /app/public /app/public

# Expose the port
EXPOSE 8080

# Start PHP-FPM
CMD ["php-fpm", "-F"]
