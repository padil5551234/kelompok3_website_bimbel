# Panduan Memperbaiki Sistem Folder Materi

## Masalah: "Tampilan folder tidak bisa"

Jika Anda mengalami masalah dengan tampilan folder yang tidak berfungsi, ikuti langkah-langkah berikut:

## Langkah-langkah Perbaikan

### 1. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 2. Bersihkan Cache
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### 3. Test Sistem Folder
```bash
php test_folder_system.php
```

### 4. Test URL Folder
Buka di browser: `http://yoursite.com/materials?view=folders`

## Kemungkinan Penyebab dan Solusi

### A. Database Tables Belum Ada
**Gejala**: Error "Table 'material_folders' doesn't exist"

**Solusi**:
1. Jalankan migration: `php artisan migrate`
2. Jika masih error, periksa file migration:
   - `database/migrations/2025_12_11_130502_create_material_folders_table.php`
   - `database/migrations/2025_12_11_130452_add_folder_id_to_materials_table.php`

### B. Route Tidak Terdaftar
**Gejala**: Error 404 saat akses folder

**Solusi**:
1. Bersihkan route cache: `php artisan route:clear`
2. Check routes: `php artisan route:list | grep materials`
3. Pastikan routes berikut ada:
   - `user.materials.index`
   - `user.materials.folders.index`

### C. Model Error
**Gejala**: Error "Class MaterialFolder not found"

**Solusi**:
1. Pastikan file `app/Models/MaterialFolder.php` ada
2. Check composer autoload: `composer dump-autoload`
3. Clear config cache: `php artisan config:clear`

### D. View File Tidak Ditemukan
**Gejala**: Error "View not found"

**Solusi**:
1. Pastikan file berikut ada:
   - `resources/views/views_user/materials/folders/index.blade.php`
   - `resources/views/views_user/materials/folders/show.blade.php`
2. Clear view cache: `php artisan view:clear`

### E. Toggle Button Tidak Berfungsi
**Gejala**: Button "Tampilan Folder" tidak mengubah tampilan

**Solusi**:
1. Check JavaScript errors di browser console
2. Pastikan URL yang dihasilkan benar: `/materials?view=folders`
3. Clear browser cache

## Testing Manual

### Test 1: Akses Folder View
1. Login ke aplikasi
2. Buka: `/materials?view=folders`
3. Should show folder interface (even if empty)

### Test 2: Toggle Button
1. Buka `/materials`
2. Click "Tampilan Folder" button
3. Should redirect to `/materials?view=folders`

### Test 3: Sample Data
Untuk test dengan data sample:
```bash
php artisan db:seed --class=MaterialFolderSeeder
```

## Debugging Lanjutan

### 1. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### 2. Enable Debug Mode
Edit `.env`:
```
APP_DEBUG=true
```

### 3. Check Database Connection
Test koneksi database di tinker:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### 4. Test Model
```bash
php artisan tinker
>>> use App\Models\MaterialFolder;
>>> MaterialFolder::count();
```

## Jika Masih Tidak Berfungsi

### Checklist Final:
- [ ] Migration sudah dijalankan
- [ ] Cache sudah dibersihkan
- [ ] File model ada dan benar
- [ ] File view ada dan benar
- [ ] Routes terdaftar dengan benar
- [ ] Database connection aktif
- [ ] User memiliki akses yang tepat

### Backup Plan:
Jika sistem folder masih tidak berfungsi, Anda bisa:
1. Kembali ke tampilan Grid normal (sudah tetap berfungsi)
2. Gunakan link langsung: `/materials` (tanpa parameter view)
3. Sistem lama tetap berjalan normal

## Contact Support

Jika semua langkah sudah dicoba dan masih tidak berfungsi, hubungi developer dengan informasi:
1. Error message yang muncul
2. Output dari `php test_folder_system.php`
3. Isi file `storage/logs/laravel.log`
4. Browser console errors (jika ada)

## Implementasi Bertahap

Sistem folder dirancang untuk tidak mengganggu sistem yang sudah ada:
- ✅ Tampilan Grid tetap berfungsi normal
- ✅ Semua fitur lama tetap tersedia
- ✅ Tidak ada breaking changes
- ✅ Backward compatibility terjaga

Jika ada masalah, Anda bisa kembali ke sistem lama kapan saja.