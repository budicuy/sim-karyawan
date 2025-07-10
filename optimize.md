# Laravel Performance Optimization Commands

# 1. Config Cache - Cache semua konfigurasi untuk produksi

php artisan config:cache

# 2. Route Cache - Cache semua route untuk produksi

php artisan route:cache

# 3. View Cache - Cache semua view untuk produksi

php artisan view:cache

# 4. Optimize - Gabungan cache config, route, dan view

php artisan optimize

# 5. Storage Link - Buat symbolic link untuk storage

php artisan storage:link

# 6. Migrate dengan index

php artisan migrate

# 7. Build assets untuk produksi

pnpm run build

# Untuk development, gunakan:

# php artisan optimize:clear - untuk clear semua cache
