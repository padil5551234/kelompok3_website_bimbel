# ⚡ Quick Start Guide - Deploy ke InfinityFree

## 🎯 Ringkasan Singkat

### Struktur Folder di InfinityFree
```
InfinityFree Server:
│
├── /htdocs/                    ← Public folder (Document Root)
│   ├── index.php              ← Entry point (dari deployment/htdocs-index.php)
│   ├── .htaccess              ← URL rewriting (dari deployment/htdocs-.htaccess)
│   ├── css/                   ← Assets dari public/css/
│   ├── js/                    ← Assets dari public/js/
│   └── images/                ← Assets dari public/images/
│
└── /laravel/                   ← Laravel application files
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/               ← Set permission 755!
    ├── vendor/                ← WAJIB di-upload!
    ├── .env                   ← Dari deployment/.env.production
    └── artisan
```

## 📝 Checklist Deployment (5 Langkah)

### ✅ Step 1: Persiapan Local
```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Optimize cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Catat Application Key
php artisan key:generate --show
```

### ✅ Step 2: Buat Akun InfinityFree
1. Daftar di: https://infinityfree.net
2. Buat akun hosting (gratis)
3. **Catat credentials**:
   - FTP: `ftpupload.net` atau `ftp.yourdomain.infinityfreeapp.com`
   - MySQL Host: `sql###.infinityfree.com`
   - Database Name: `epiz_#####_dbname`
   - Database User: `epiz_#####`
   - Database Password: `***`

### ✅ Step 3: Upload Files

**Via FTP (Recommended - FileZilla):**

1. **Upload ke `/laravel/`** (buat folder baru):
   ```
   ✓ app/
   ✓ bootstrap/
   ✓ config/
   ✓ database/
   ✓ resources/
   ✓ routes/
   ✓ storage/
   ✓ vendor/          ← PENTING!
   ✓ artisan
   ✓ composer.json
   ✓ composer.lock
   ```

2. **Upload ke `/htdocs/`** (sudah ada):
   ```
   Dari folder public/:
   ✓ css/
   ✓ js/
   ✓ images/
   ✓ fonts/
   ✓ favicon.ico
   
   Dari deployment/:
   ✓ htdocs-index.php → rename jadi index.php
   ✓ htdocs-.htaccess → rename jadi .htaccess
   ```

3. **Upload `.env`**:
   ```
   deployment/.env.production → upload ke /laravel/.env
   Edit di File Manager cPanel, sesuaikan:
   - APP_KEY (dari step 1)
   - APP_URL
   - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
   ```

### ✅ Step 4: Set Permissions

Via cPanel File Manager:
1. Klik kanan `/laravel/storage/` → Change Permissions → `755` (recursive)
2. Klik kanan `/laravel/bootstrap/cache/` → Change Permissions → `755` (recursive)

### ✅ Step 5: Setup Database

**Option A - Import SQL:**
1. cPanel → phpMyAdmin
2. Select database
3. Import → Choose File → database.sql
4. Go

**Option B - Migration Helper:**
1. Upload `deployment/migrate.php` ke `/htdocs/`
2. Akses: `https://yourdomain.infinityfreeapp.com/migrate.php`
3. ⚠️ **HAPUS file setelah selesai!**

## 🧪 Testing

### Test 1: Check System
```
1. Upload deployment/check-system.php ke /htdocs/
2. Akses: https://yourdomain.infinityfreeapp.com/check-system.php
3. Lihat status semua komponen
4. ⚠️ HAPUS file setelah selesai!
```

### Test 2: Clear Cache (jika perlu)
```
1. Upload deployment/clear-cache.php ke /htdocs/
2. Akses: https://yourdomain.infinityfreeapp.com/clear-cache.php
3. ⚠️ HAPUS file setelah selesai!
```

### Test 3: Homepage
```
Akses: https://yourdomain.infinityfreeapp.com
Expected: Homepage aplikasi muncul
```

## 🔧 Common Issues & Quick Fix

### ❌ Error: "Class not found"
```
Cause: Folder vendor tidak ter-upload
Fix: Upload folder vendor/ lengkap (~50-100MB)
```

### ❌ Error 500 - Internal Server Error
```
Cause: 
1. Permission storage/bootstrap salah
2. .env salah konfigurasi
3. .htaccess missing

Fix:
1. Set permission 755 untuk storage & bootstrap/cache
2. Check .env configuration
3. Upload .htaccess ke /htdocs/
```

### ❌ Database Connection Failed
```
Cause: Credentials salah di .env

Fix:
1. Login cPanel → MySQL Databases
2. Verifikasi nama database, user, password
3. Update /laravel/.env
4. Clear config cache (gunakan clear-cache.php)
```

### ❌ CSS/JS Not Loading
```
Cause: 
1. APP_URL salah di .env
2. Asset files belum ter-upload

Fix:
1. Set APP_URL=https://yourdomain.infinityfreeapp.com di .env
2. Upload semua file dari public/ ke /htdocs/
3. Check path di HTML menggunakan asset() helper
```

### ❌ Midtrans Payment Error
```
Fix:
1. Update APP_URL di .env
2. Login Midtrans Dashboard
3. Update Callback URL ke:
   https://yourdomain.infinityfreeapp.com/api/midtrans/callback
4. Set MIDTRANS_IS_PRODUCTION=true
5. Gunakan production keys
```

## 📱 Update Midtrans Settings

Setelah deploy, update di Midtrans Dashboard:

**1. Settings → Configuration:**
```
Payment Notification URL:
https://yourdomain.infinityfreeapp.com/api/midtrans/callback

Finish Redirect URL:
https://yourdomain.infinityfreeapp.com/pembelian/success

Unfinish Redirect URL:
https://yourdomain.infinityfreeapp.com/pembelian/pending

Error Redirect URL:
https://yourdomain.infinityfreeapp.com/pembelian/error
```

**2. Update `.env`:**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx (Production)
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx (Production)
MIDTRANS_IS_PRODUCTION=true
```

## ⚠️ File yang HARUS DIHAPUS

Setelah deployment selesai, HAPUS:
- ❌ `/htdocs/migrate.php`
- ❌ `/htdocs/clear-cache.php`
- ❌ `/htdocs/check-system.php`
- ❌ Any testing/debug files

## 🔐 Security Checklist

- [ ] `APP_DEBUG=false` di .env
- [ ] `APP_ENV=production` di .env
- [ ] Hapus semua helper files
- [ ] Set permission yang benar (755 untuk folders, 644 untuk files)
- [ ] Database credentials aman
- [ ] `.env` tidak bisa diakses public (protected by .htaccess)

## 📊 Final Check

```bash
✓ Website loading dengan benar
✓ Login/Register berfungsi
✓ Dashboard user bisa diakses
✓ Database connected
✓ Asset files (CSS/JS) loading
✓ Midtrans payment test berhasil
✓ Semua helper files sudah dihapus
✓ APP_DEBUG=false
✓ Storage writable (permission 755)
```

## 🚀 Ready to Go!

Website Anda sekarang live di: `https://yourdomain.infinityfreeapp.com`

## 📚 Dokumentasi Lengkap

Untuk panduan detail, baca:
- [`PANDUAN_UPLOAD_INFINITYFREE.md`](../PANDUAN_UPLOAD_INFINITYFREE.md) - Panduan lengkap
- [`deployment/README.md`](README.md) - Deskripsi deployment files

## 💡 Tips Pro

1. **Backup Regular**: Export database via phpMyAdmin setiap minggu
2. **Monitor Logs**: Check storage/logs/laravel.log via FTP
3. **Update Dependencies**: `composer update` di local, upload vendor baru
4. **Test Payment**: Test Midtrans di production mode
5. **Custom Domain**: Bisa pakai custom domain (gratis) di InfinityFree

## 🆘 Need Help?

- InfinityFree Forum: https://forum.infinityfree.net/
- Laravel Docs: https://laravel.com/docs
- Contact Developer: [Your Contact]

---

**Happy Deploying! 🎉**