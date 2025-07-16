# Gunakan base image resmi FrankenPHP untuk Laravel
FROM dunglas/frankenphp:latest-php8.3-laravel

# Set variabel lingkungan untuk instalasi non-interaktif
ENV DEBIAN_FRONTEND=noninteractive

# Install dependensi sistem yang diperlukan
# - libpq-dev: untuk ekstensi PHP pgsql
# - wget, gnupg: untuk menambahkan repositori Chrome
# - Kumpulan library untuk menjalankan headless Chrome (Puppeteer)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    wget \
    gnupg \
    # Dependensi untuk Puppeteer/Browsershot
    ca-certificates \
    fonts-liberation \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libc6 \
    libcairo2 \
    libcups2 \
    libdbus-1-3 \
    libexpat1 \
    libfontconfig1 \
    libgbm1 \
    libgcc1 \
    libglib2.0-0 \
    libgtk-3-0 \
    libnspr4 \
    libnss3 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    libstdc++6 \
    libx11-6 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxext6 \
    libxfixes3 \
    libxi6 \
    libxrandr2 \
    libxrender1 \
    libxss1 \
    libxtst6 \
    lsb-release \
    xdg-utils \
    && rm -rf /var/lib/apt/lists/*

# Install Google Chrome
RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y google-chrome-stable \
    && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_pgsql zip

# Install Node.js dan pnpm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g pnpm

# Set direktori kerja
WORKDIR /app

# Salin file proyek
COPY . .

# Install dependensi Composer
RUN composer install --no-dev --optimize-autoloader

# Install dependensi NPM dan build aset
RUN pnpm install
RUN pnpm run build

# Atur izin folder
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port (akan digunakan oleh run_command di app.yaml)
EXPOSE 8080
