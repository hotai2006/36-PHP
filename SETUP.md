# 🛠️ Hướng dẫn Setup - Sports Laravel Shop

## 📋 Yêu cầu

- **Docker** và **Docker Compose** (cài đặt từ [docker.com](https://www.docker.com))
- **Git** (optional, nếu muốn clone repo)

## 🚀 Cách Setup

### 1️⃣ Clone hoặc tải project
```bash
# Option A: Dùng Git
git clone https://github.com/TrungLuu2910/PHP_WebTheThao.git
cd PHP_WebTheThao

# Option B: Tải file ZIP từ GitHub
# Giải nén và cd vào thư mục
```

### 2️⃣ Chuẩn bị file .env
```bash
# Copy .env.example thành .env
cp .env.example .env

# Trên Windows (PowerShell):
Copy-Item .env.example .env
```

### 3️⃣ Build và chạy Docker
```bash
# Build images và start containers
docker-compose up -d

# Xem logs (nếu cần debug)
docker-compose logs -f laravel-app
```

### 4️⃣ Cài đặt dependencies PHP
```bash
# Chạy composer install bên trong container
docker exec laravel-app composer install
```

### 5️⃣ Generate APP_KEY
```bash
docker exec laravel-app php artisan key:generate
```

### 6️⃣ Migration database
```bash
# Chạy migration
docker exec laravel-app php artisan migrate

# Seed dữ liệu mẫu (nếu có)
docker exec laravel-app php artisan db:seed
```

### 7️⃣ Compile frontend (nếu cần)
```bash
docker exec laravel-app npm install
docker exec laravel-app npm run build
```

### 8️⃣ Kiểm tra ứng dụng
- Mở trình duyệt: **http://localhost:8000**
- Xem logs: `docker-compose logs -f laravel-app`

---

## 🐳 Các lệnh Docker thường dùng

```bash
# Khởi động containers
docker-compose up -d

# Dừng containers
docker-compose down

# Xem logs
docker-compose logs -f laravel-app

# Chạy lệnh artisan
docker exec laravel-app php artisan <command>

# Truy cập terminal container
docker exec -it laravel-app bash

# Xóa toàn bộ (containers, volumes, networks)
docker-compose down -v
```

---

## 📁 Cấu trúc dự án

```
├── app/                 # Application code
├── config/             # Configuration files
├── database/           # Migrations & Seeders
├── public/             # Public assets
├── resources/          # Views & frontend
├── routes/             # API & Web routes
├── docker-compose.yml  # Docker services
├── Dockerfile          # Image definition
└── .env.example        # Environment template
```

---

## 🔧 Services

### Laravel App
- **URL:** http://localhost:8000
- **Container:** laravel-app
- **Port:** 8000

### MySQL Database
- **Host:** mysql-db
- **Port:** 3306
- **Database:** sports
- **Username:** root
- **Password:** (empty)

---

## 🐛 Troubleshooting

### Port 8000 đang được sử dụng
```bash
# Thay đổi port trong docker-compose.yml
# Tìm: ports: - "8000:80"
# Đổi thành: ports: - "8001:80"
```

### Database connection error
```bash
# Restart MySQL container
docker-compose restart mysql-db

# Check logs
docker-compose logs mysql-db
```

### Permission denied errors
```bash
# Đổi quyền storage folder
docker exec laravel-app chmod -R 775 storage bootstrap/cache
```

### Xóa cache
```bash
docker exec laravel-app php artisan cache:clear
docker exec laravel-app php artisan config:clear
docker exec laravel-app php artisan view:clear
```

---

## 📝 Lưu ý quan trọng

- ⚠️ Không push `.env` file lên Git (đã có `.gitignore`)
- 💾 Dữ liệu MySQL lưu trong volume `mysql_data` (persist khi stop container)
- 🔐 Thay đổi password database trong `.env` trước khi deploy
- 📦 Mỗi lần thay đổi `composer.json` hay `package.json`, cần rebuild: `docker-compose up -d --build`

---

## ✅ Kiểm tra setup thành công

- [ ] Truy cập http://localhost:8000 - Trang chủ load bình thường
- [ ] Database migrations chạy không lỗi
- [ ] Có thể đăng nhập/đăng ký tài khoản
- [ ] Các API endpoint hoạt động

---

**Cần giúp đỡ? Kiểm tra logs:**
```bash
docker-compose logs -f
```

Happy coding! 🚀
