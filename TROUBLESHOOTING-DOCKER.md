# 🐳 Hướng dẫn Debug Docker trên Windows

> Tài liệu này ghi lại các lỗi đã gặp và cách khắc phục khi chạy Laravel qua Docker trên Windows.

---

## 📋 Các lỗi đã fix

### 1. Lỗi session: `file_put_contents(...storage/framework/sessions/...): Failed to open stream`

**Nguyên nhân:**
Docker Desktop trên Windows sử dụng bind-mount, khi mount thư mục từ Windows vào container Linux, quyền `www-data` bị mất sau mỗi lần restart. Lệnh `chown` trong Dockerfile chỉ có tác dụng tại thời điểm build, nhưng bị ghi đè bởi volume mount khi chạy container.

**Cách fix thủ công:**
```bash
docker exec laravel-app chmod -R 777 storage bootstrap/cache public
docker exec laravel-app chown -R www-data:www-data storage bootstrap/cache public
docker exec laravel-app php artisan optimize:clear
```

**Đã fix cứng trong:** `docker-entrypoint.sh` — chạy `chmod -R 777` và `chown` mỗi khi container khởi động.

---

### 2. Lỗi database: `SQLSTATE[HY000] [2002] getaddrinfo for mysql-db failed`

**Nguyên nhân:**
Container `laravel-app` khởi động trước khi `mysql-db` sẵn sàng, hoặc Docker DNS chưa kịp resolve hostname `mysql-db`.

**Cách fix thủ công:**
```bash
docker-compose restart
```

**Đã fix cứng trong:** `docker-compose.yml` — thêm `condition: service_healthy` cho `depends_on`.

---

### 3. Lỗi view: `View [client.homePage.homePage] not found`

**Nguyên nhân:**
Cache view cũ (Blade templates) chứa đường dẫn Windows hoặc nội dung cũ không tương thích.

**Cách fix thủ công:**
```bash
docker exec laravel-app php artisan view:clear
docker exec laravel-app php artisan view:cache
```

**Đã fix cứng trong:** `docker-entrypoint.sh` — tự động `view:clear` và cache lại mỗi khi khởi động.

---

### 4. Lỗi file not found: `default-avatar.jpg`

**Nguyên nhân:**
File avatar mặc định không tồn tại trong `storage/app/public/avatars/`.

**Cách fix:**
Tạo file avatar mặc định hoặc sửa code để bỏ qua khi không có avatar.

```bash
# Kiểm tra
docker exec laravel-app ls -la /var/www/public/storage/avatars/
```

---

## 🛠️ Các lệnh debug nhanh

### Kiểm tra container
```bash
docker ps -a
docker logs laravel-app --tail 50
```

### Kiểm tra log Laravel
```bash
docker exec laravel-app tail -50 storage/logs/laravel.log
```

### Clear toàn bộ cache
```bash
docker exec laravel-app php artisan optimize:clear
```

### Reset permissions
```bash
docker exec laravel-app chmod -R 777 storage bootstrap/cache public
docker exec laravel-app chown -R www-data:www-data storage bootstrap/cache public
```

### Restart toàn bộ
```bash
docker-compose restart
# hoặc
docker-compose down && docker-compose up -d
```

### Kết nối database
```bash
docker exec mysql-db mysql -u root fruitshop
```

---

## ⚙️ Cấu trúc volumes (docker-compose.yml)

```yaml
volumes:
  - ./storage:/var/www/storage              # Bind mount từ Windows
  - storage_sessions:/var/www/storage/framework/sessions  # Named volume
```

⚠️ **Lưu ý:** Named volume `storage_sessions` lưu trong Docker VM (không phải ổ Windows). Nếu cần xóa session cũ:
```bash
docker-compose down -v   # CẢNH BÁO: Xóa TOÀN BỘ volumes kể cả database!
```

Để chỉ xóa session volume:
```bash
docker volume rm php_webthethao-maintai1_storage_sessions
```

---

## 💡 Nếu vẫn còn lỗi

Thử chạy Laravel trực tiếp trên Windows (không Docker):

```bash
# Chạy trên Windows (đã có PHP 8.2.12)
cd C:\Users\DELL\OneDrive\Máy tính\PHP_WebTheThao-main(tai1)
php artisan serve
```

Truy cập `http://localhost:8000`
