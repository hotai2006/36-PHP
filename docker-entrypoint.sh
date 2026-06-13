#!/bin/bash

# ============================================
# DOCKER ENTRYPOINT - LARAVEL APP
# ============================================

# --- Tạo các thư mục cần thiết trong storage và bootstrap trước khi chạy composer/app ---
echo "[Tạo thư mục cần thiết...] Tạo thư mục storage và bootstrap/cache..."
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/app/public
mkdir -p /var/www/bootstrap/cache

# --- THIẾT LẬP QUYỀN TRUY CẬP BAN ĐẦU ---
echo "[Thiết lập quyền...] Set quyền cho các thư mục mới tạo..."
chmod -R 777 /var/www/storage /var/www/bootstrap/cache /var/www/public
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public

# --- Cài đặt Composer dependencies nếu chưa có ---
if [ ! -f /var/www/vendor/autoload.php ]; then
    echo "[0/7] Cài đặt Composer dependencies..."
    cd /var/www && composer install --no-interaction --prefer-dist || exit 1
    echo "[0/7] ✅ Composer dependencies installed"
fi

# --- Chờ MySQL sẵn sàng trước khi start app ---
echo "[1/7] Đang chờ MySQL sẵn sàng..."
MAX_RETRIES=45
RETRY_COUNT=0
while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if php -r "@new PDO('mysql:host=${DB_HOST:-mysql-db};port=${DB_PORT:-3306}', '${DB_USERNAME:-root}', '${DB_PASSWORD:-}');" 2>/dev/null; then
        echo "[1/7] MySQL đã sẵn sàng!"
        break
    fi
    RETRY_COUNT=$((RETRY_COUNT + 1))
    echo "[1/7] MySQL chưa sẵn sàng... thử lại ($RETRY_COUNT/$MAX_RETRIES)"
    sleep 2
done

if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
    echo "[1/7] ⚠️ CẢNH BÁO: MySQL không sẵn sàng sau ${MAX_RETRIES} lần thử."
fi

# Kiểm tra session directory có thể ghi được không
if touch /var/www/storage/framework/sessions/.docker-write-test 2>/dev/null; then
    rm -f /var/www/storage/framework/sessions/.docker-write-test
    echo "[3/7] ✅ Session directory writable"
else
    echo "[3/7] ⚠️ Session directory NOT writable - thử fix lần 2..."
    chmod -R 777 /var/www/storage
    chown -R www-data:www-data /var/www/storage
fi

# --- Xóa toàn bộ cache cũ ---
echo "[4/7] Xóa cache cũ..."
php artisan optimize:clear
echo "[4/7] ✅ Cache cleared"

# --- Cài đặt key Laravel ---
echo "[5/7] Cài đặt app key..."
php artisan key:generate --force
echo "[5/7] ✅ App key generated"

# --- Tạo symbolic link ---
echo "[6/7] Tạo storage link..."
php artisan storage:link --force
echo "[6/7] ✅ Storage linked"

# --- Khởi động server ---
echo "[7/7] 🚀 Khởi động PHP Artisan Server..."
echo ""
php artisan serve --host=0.0.0.0 --port=80

# Tự động dọn dẹp liên kết ảo cũ bị kẹt của máy khác
rm -rf public/storage

# Tự động liên kết lại thư mục ảnh theo máy hiện tại
php artisan storage:link

# Xóa bộ nhớ đệm giao diện để cập nhật ảnh mới tinh
php artisan view:clear
