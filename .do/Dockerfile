# Base image FrankenPHP
FROM dunglas/frankenphp:1-php8.3-laravel

# Install system dependencies
# Termasuk dependensi untuk pgsql dan dependensi untuk Puppeteer/Browsershot
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    # Dependencies for Puppeteer/Browsershot
    && apt-get install -y --no-install-recommends \
    libx11-xcb1 libxrandr2 libxcomposite1 libxcursor1 libxdamage1 libxi6 libxtst6 libnss3 libcups2 libxss1 libasound2 libatk1.0-0 libatk-bridge2.0-0 libpangocairo-1.0-0 libgtk-3-0 \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql zip

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Install Google Chrome for Puppeteer
RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb && \
    apt-get install -y ./google-chrome-stable_current_amd64.deb && \
    rm google-chrome-stable_current_amd64.deb

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install Composer dependencies
# Pastikan laravel/octane sudah ada di composer.json
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port (FrankenPHP default)
EXPOSE 8080

# Perintah run akan di-handle oleh app.yaml
# CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8080"]
