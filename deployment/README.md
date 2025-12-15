# 🚀 Deployment Files untuk InfinityFree

Folder ini berisi file-file helper untuk mempermudah deployment proyek Laravel ke InfinityFree.net

## 📁 Daftar File

### 1. `.env.production`
**Fungsi**: Template file environment untuk production
**Cara Pakai**:
1. Copy file ini
2. Rename menjadi `.env`
3. Upload ke folder `/laravel/.env` di InfinityFree
4. Edit dan sesuaikan dengan credentials Anda

### 2. `htdocs-index.php`
**Fungsi**: Entry point Laravel untuk folder public
**Cara Pakai**:
1. Upload file ini ke `/htdocs/index.php` di InfinityFree
2. Pastikan path ke Laravel folder sudah benar (`../laravel/`)

### 3. `htdocs-.htaccess`
**Fungsi**: Configuration Apache untuk URL rewriting
**Cara Pakai**:
1. Rename file ini menjadi `.htaccess` (hapus prefix `htdocs-`)
2. Upload ke `/htdocs/.htaccess` di InfinityFree

### 4. `migrate.php`
**Fungsi**: Helper untuk menjalankan migration dan seeder
**Cara Pakai**:
1. Upload file ini ke `/htdocs/migrate.php` di InfinityFree
2. Akses via browser: `https://yourdomain.infinityfreeapp.com/migrate.php`
3. ⚠️ **HAPUS file ini setelah selesai migrasi!**

### 5. `clear-cache.php`
**Fungsi**: Helper untuk clear cache aplikasi
**Cara Pakai**:
1. Upload file ini ke `/htdocs/clear-cache.php` di InfinityFree
2. Akses via browser: `https://yourdomain.infinityfreeapp.com/clear-cache.php`
3. ⚠️ **HAPUS file ini setelah selesai clear cache!**

## 📋 Urutan Deployment

### Persiapan Local
```bash
# 1. Install dependencies
composer install --optimize-autoloader --no-dev

# 2. Optimize aplikasi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Generate app key (catat hasilnya)
php artisan key:generate --show
```

### Upload ke InfinityFree

#### Step 1: Upload Laravel Core Files
Upload ke `/laravel/` (buat folder ini):
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/`
- `vendor/` ⚠️ **PENTING: Upload folder ini!**
- `artisan`
- `composer.json`
- `composer.lock`

#### Step 2: Upload Public Files
Upload isi folder `public/` ke `/htdocs/`:
- Semua file CSS, JS, images
- ⚠️ **JANGAN upload index.php dari public, gunakan yang ada di deployment**

#### Step 3: Setup Configuration Files
1. Upload `htdocs-index.php` → `/htdocs/index.php`
2. Upload `htdocs-.htaccess` (rename ke `.htaccess`) → `/htdocs/.htaccess`
3. Upload `.env.production` (rename ke `.env`) → `/laravel/.env`
4. Edit `/laravel/.env` sesuai credentials InfinityFree

#### Step 4: Set Permissions
Via cPanel File Manager, set permission:
- `/laravel/storage/` → 755 (recursive)
- `/laravel/bootstrap/cache/` → 755 (recursive)

#### Step 5: Setup Database
1. Buka phpMyAdmin di cPanel
2. Import database Anda
3. Atau upload `migrate.php` ke `/htdocs/` dan akses via browser

#### Step 6: Test & Clear Cache
1. Upload `clear-cache.php` ke `/htdocs/`
2. Akses via browser untuk clear cache
3. Test website Anda
4. ⚠️ **Hapus semua helper files (migrate.php, clear-cache.php)**

## ⚠️ Peringatan Keamanan

### File yang HARUS DIHAPUS setelah deployment:
- `/htdocs/migrate.php`
- `/htdocs/clear-cache.php`
- Semua file testing/debugging

### File yang HARUS DILINDUNGI:
- `/laravel/.env` (sudah protected via .htaccess)
- `/laravel/storage/` (set permission dengan benar)
- Database credentials

## 🔧 Troubleshooting

### Error: "Class not found"
**Solusi**: Pastikan folder `vendor/` ter-upload dengan lengkap

### Error: "Permission denied on storage"
**Solusi**: Set permission 755 untuk folder storage dan bootstrap/cache

### Error: "Database connection failed"
**Solusi**: 
1. Cek credentials di `.env`
2. Pastikan database sudah dibuat di cPanel
3. Test koneksi via phpMyAdmin

### Assets (CSS/JS) tidak load
**Solusi**:
1. Cek `APP_URL` di `.env`
2. Pastikan file assets ada di `/htdocs/`
3. Clear browser cache

## 📞 Bantuan

Jika ada masalah, baca panduan lengkap di [`PANDUAN_UPLOAD_INFINITYFREE.md`](../PANDUAN_UPLOAD_INFINITYFREE.md)

## 🎯 Checklist Deployment

- [ ] Install dependencies local (`composer install --no-dev`)
- [ ] Optimize Laravel (config, route, view cache)
- [ ] Upload Laravel files ke `/laravel/`
- [ ] Upload public files ke `/htdocs/`
- [ ] Upload & setup index.php di `/htdocs/`
- [ ] Upload & setup .htaccess di `/htdocs/`
- [ ] Setup .env di `/laravel/`
- [ ] Set permissions (storage & bootstrap/cache)
- [ ] Import/migrate database
- [ ] Clear cache
- [ ] Test website
- [ ] Hapus helper files (migrate.php, clear-cache.php)
- [ ] Update Midtrans callback URL
- [ ] Test pembayaran (jika ada)

---

**Catatan**: InfinityFree adalah hosting gratis dengan limitasi. Untuk production serius, pertimbangkan paid hosting.