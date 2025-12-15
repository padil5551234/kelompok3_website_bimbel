# Perbaikan Error Foreign Key Constraint

## Error yang Terjadi:
```
Illuminate\Database\QueryException 
SQLSTATE[HY000]: General error: 1005 Can't create table `tryout`.`materials` (errno: 150 "Foreign key constraint is incorrectly formed")
```

## Penyebab Masalah:
Error terjadi karena foreign key constraint mencoba referensi ke tabel `material_folders` yang belum ada saat migration berjalan.

## Solusi yang Telah Diterapkan:

### 1. **Memisahkan Migration**
Migration telah dipisahkan menjadi 3 tahap:

1. **`2025_12_11_130452_add_folder_id_to_materials_table.php`**
   - Menambahkan kolom `folder_id` ke tabel `materials`
   - **Tanpa foreign key constraint**

2. **`2025_12_11_130502_create_material_folders_table.php`**
   - Membuat tabel `material_folders`

3. **`2025_12_11_131632_add_foreign_key_folder_id_to_materials_table.php`**
   - Menambahkan foreign key constraint setelah tabel `material_folders` ada

### 2. **Urutan Eksekusi yang Benar**
Sekarang migration akan berjalan dengan urutan:
1. Tambah kolom `folder_id` (tanpa constraint)
2. Buat tabel `material_folders`
3. Tambah foreign key constraint

## Cara Menjalankan Perbaikan:

### **Langkah 1: Rollback Migration (jika perlu)**
```bash
php artisan migrate:rollback --step=1
```

### **Langkah 2: Jalankan Migration Baru**
```bash
php artisan migrate
```

### **Langkah 3: Verifikasi**
```bash
php test_folder_system.php
```

## Struktur Database yang Benar:

### Tabel `materials`:
- ✅ Kolom `folder_id` (uuid, nullable)
- ✅ Foreign key ke `material_folders.id` (dengan ON DELETE CASCADE)

### Tabel `material_folders`:
- ✅ Kolom `id` (uuid, primary key)
- ✅ Kolom `batch_id`, `title`, `description`, dll
- ✅ Foreign key ke `paket_ujians.id` dan `users.id`

## Testing:

Setelah migration berhasil, test dengan:
1. **Login ke aplikasi**
2. **Buka Materials page**
3. **Click "Tampilan Folder"**
4. **Should show folder interface**

## Jika Masih Error:

### **Check 1: Database Connection**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### **Check 2: Migration Status**
```bash
php artisan migrate:status
```

### **Check 3: Table Structure**
```bash
php artisan tinker
>>> Schema::getColumnListing('materials');
>>> Schema::getColumnListing('material_folders');
```

## Notes Penting:

- ✅ **Backward Compatibility**: Sistem lama tetap berfungsi
- ✅ **Graceful Degradation**: Jika folder belum ada, tampilkan materi biasa
- ✅ **Error Handling**: Controller sudah ada try-catch untuk handle missing tables
- ✅ **Foreign Key Integrity**: Data tetap aman dengan proper constraints

## Command Summary:

```bash
# Jika fresh start
php artisan migrate:fresh
php artisan db:seed --class=MaterialFolderSeeder

# Jika sudah ada data
php artisan migrate
php artisan db:seed --class=MaterialFolderSeeder

# Test system
php test_folder_system.php
```

Perbaikan ini mengatasi masalah foreign key constraint dan sistem folder sekarang seharusnya bisa berfungsi dengan normal.