# Panduan Deploy Website Laravel Online dengan Upload Gambar & Materi

## 📋 Daftar Isi
1. [Persiapan Hosting](#1-persiapan-hosting)
2. [Upload dan Setup Project](#2-upload-dan-setup-project)
3. [Konfigurasi Environment](#3-konfigurasi-environment)
4. [Setup Database](#4-setup-database)
5. [Konfigurasi Storage untuk Upload](#5-konfigurasi-storage-untuk-upload)
6. [Setup Permissions](#6-setup-permissions)
7. [Testing Fitur Upload](#7-testing-fitur-upload)
8. [Troubleshooting](#8-troubleshooting)

## 1. Persiapan Hosting

### Rekomendasi Hosting
- **VPS/Cloud**: DigitalOcean, Vultr, AWS EC2, Google Cloud
- **Shared Hosting**: Yang mendukung PHP 8.1+, MySQL 8.0+, SSH access
- **Panel Hosting**: cPanel, Plesk, DirectAdmin

### Spesifikasi Minimum
- PHP 8.1 atau lebih tinggi
- MySQL 8.0 / MariaDB 10.3+
- RAM: 1GB minimum, 2GB recommended
- Storage: 5GB minimum
- SSH access untuk setup

## 2. Upload dan Setup Project

### Upload Files
```bash
# Via FTP/SFTP
# Upload semua file kecuali:
# - .env (akan dibuat baru)
# - storage/ (kecuali storage/app dan storage/logs)
# - vendor/ (jika composer install di server)
# - node_modules/

# Via Git (recommended)
git clone https://github.com/your-repo/bimbel-tryout.git
cd bimbel-tryout
```

### Install Dependencies
```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies (jika ada)
npm install
npm run build
```

## 3. Konfigurasi Environment

### Setup .env File
```bash
cp .env.example .env
```

Edit `.env` dengan konfigurasi production:
```env
APP_NAME="Bimbel Tryout"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password

# Storage
FILESYSTEM_DISK=public

# Generate APP_KEY jika belum ada
php artisan key:generate
```

## 4. Setup Database

### Buat Database
```sql
CREATE DATABASE bimbel_tryout CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tryout_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON bimbel_tryout.* TO 'tryout_user'@'localhost';
FLUSH PRIVILEGES;
```

### Jalankan Migration & Seeder
```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder (opsional, untuk data awal)
php artisan db:seed
```

## 5. Konfigurasi Storage untuk Upload

### Setup Storage Link (KRITIS untuk Upload)
```bash
# Method 1: Symlink (recommended jika hosting mendukung)
php artisan storage:link

# Method 2: Manual copy (untuk hosting tanpa symlink)
php deployment/create-storage-link.php
```

### Verifikasi Storage Setup
```bash
# Cek apakah folder storage ada
ls -la public/storage

# Jika symlink: public/storage -> ../../storage/app/public
# Jika manual copy: public/storage/ berisi file-file upload
```

### Setup Permissions Storage
```bash
# Set permissions untuk folder storage
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Untuk hosting shared, biasanya:
# chown -R www-data:www-data storage/
# chown -R www-data:www-data bootstrap/cache/
```

## 6. Setup Permissions

### File Permissions
```bash
# Set proper permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Jika ada queue worker
chmod +x artisan
```

### Web Server Configuration

#### Apache (.htaccess sudah ada)
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/your/project/public

    <Directory /path/to/your/project/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

    # Handle uploaded files
    location /storage/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## 7. Testing Fitur Upload

### Test Upload Bukti Transfer
1. Login sebagai user
2. Beli paket ujian
3. Pilih metode pembayaran manual
4. Upload bukti transfer
5. Verifikasi gambar muncul di admin panel

### Test Upload Materi (Tutor)
1. Login sebagai tutor
2. Pergi ke `/tutor/materials/create`
3. Upload file materi dan thumbnail
4. Verifikasi file bisa diakses

### Test Upload Gambar Soal (Admin)
1. Login sebagai admin
2. Buat/Edit soal
3. Upload gambar soal
4. Verifikasi gambar muncul di soal

## 8. Troubleshooting

### ❌ Gambar Tidak Muncul Setelah Upload

**Penyebab**: Storage link tidak bekerja
**Solusi**:
```bash
# Cek storage link
ls -la public/storage

# Jika tidak ada, buat ulang
rm -rf public/storage
php artisan storage:link

# Atau gunakan script manual
php deployment/create-storage-link.php
```

### ❌ 403 Forbidden pada Storage

**Penyebab**: Permissions salah
**Solusi**:
```bash
chmod -R 755 storage/
chmod -R 755 public/storage/
```

### ❌ Upload Gagal

**Penyebab**: PHP upload limits
**Solusi**: Edit `php.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
memory_limit = 256M
```

### ❌ File Tidak Bisa Didownload

**Penyebab**: MIME type atau permissions
**Solusi**:
```bash
# Cek MIME types di .htaccess
# Tambahkan jika perlu:
AddType application/pdf .pdf
AddType video/mp4 .mp4
```

### ❌ Database Connection Error

**Solusi**: Cek `.env` database credentials
```bash
php artisan config:clear
php artisan cache:clear
```

### Monitoring & Maintenance

#### Cron Jobs (untuk queue, scheduled tasks)
```bash
# Edit crontab
crontab -e

# Tambahkan:
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

#### Log Monitoring
```bash
# Cek Laravel logs
tail -f storage/logs/laravel.log

# Cek web server logs
tail -f /var/log/apache2/error.log
# atau
tail -f /var/log/nginx/error.log
```

#### Backup Routine
```bash
# Backup database
mysqldump -u username -p database_name > backup.sql

# Backup files
tar -czf backup_files.tar.gz /path/to/project --exclude='vendor' --exclude='node_modules'
```

## 🚀 Quick Deployment Checklist

- [ ] Domain & hosting aktif
- [ ] Files terupload
- [ ] Dependencies terinstall
- [ ] .env dikonfigurasi
- [ ] Database created & migrated
- [ ] Storage link dibuat
- [ ] Permissions diset
- [ ] Web server configured
- [ ] SSL certificate (recommended)
- [ ] Test semua fitur upload
- [ ] Backup routine disetup

## 📞 Support

Jika masih ada masalah:
1. Cek logs: `storage/logs/laravel.log`
2. Cek PHP error logs
3. Cek web server error logs
4. Pastikan semua permissions benar
5. Test dengan file kecil dulu

---

**Catatan**: Pastikan selalu backup sebelum melakukan perubahan di production!