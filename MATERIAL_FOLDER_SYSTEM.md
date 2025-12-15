# Sistem Folder Materi Pembelajaran

## Ringkasan
Sistem folder materi telah ditambahkan untuk memungkinkan pengorganisasian materi pembelajaran yang lebih baik. Siswa sekarang dapat melihat materi yang dikelompokkan berdasarkan pertemuan/sesi (seperti "Pertemuan 1", "Pertemuan 2", dll.) yang berisi berbagai jenis materi seperti video, PDF, dan tautan eksternal.

## Fitur Utama

### 1. Tampilan Folder
- **Tampilan Grid**: Cara lama menampilkan materi individual
- **Tampilan Folder**: Cara baru menampilkan materi yang dikelompokkan dalam folder pertemuan
- **Toggle Button**: Tombol untuk beralih antara kedua tampilan

### 2. Organisasi Materi
- Materi dikelompokkan berdasarkan folder pertemuan
- Setiap folder dapat memiliki multiple jenis materi:
  - Video YouTube
  - Video file
  - Dokumen/PDF
  - Link eksternal
- Materi individual yang tidak masuk folder ditampilkan secara terpisah

### 3. Fitur Folder
- **Informasi Folder**: Judul, deskripsi, nomor pertemuan
- **Statistik Materi**: Jumlah materi berdasarkan jenis
- **Metadata**: Tutor, paket ujian, tanggal
- **Akses Terorganisir**: Semua materi dalam satu folder pertemuan

## Implementasi Teknis

### Model Baru
#### MaterialFolder
```php
class MaterialFolder extends Model
{
    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'order_number',
        'tutor_id',
        'is_published',
        'meeting_number',
        'meeting_title',
        'start_date',
        'end_date',
    ];
    
    public function materials()
    {
        return $this->hasMany(Material::class, 'folder_id');
    }
    
    public function batch()
    {
        return $this->belongsTo(PaketUjian::class, 'batch_id');
    }
    
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
```

### Database Changes
#### Tabel material_folders
- `id` (uuid, primary key)
- `batch_id` (uuid, foreign key to paket_ujians)
- `title` (string, nullable)
- `description` (text, nullable)
- `order_number` (integer, default 0)
- `tutor_id` (uuid, foreign key to users)
- `is_published` (boolean, default true)
- `meeting_number` (integer, nullable)
- `meeting_title` (string, nullable)
- `start_date` (timestamp, nullable)
- `end_date` (timestamp, nullable)
- `timestamps`

#### Perubahan Tabel materials
- Ditambahkan kolom `folder_id` (uuid, foreign key to material_folders)

### Routes Baru
```php
// User Material Folders routes
Route::prefix('materials/folders')
    ->name('user.materials.folders.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [UserMaterialController::class, 'foldersIndex'])
            ->name('index');
        Route::get('/{folder}', [UserMaterialController::class, 'folderShow'])
            ->name('show');
        Route::get('/package/{packageId}', [UserMaterialController::class, 'getFoldersByPackage'])
            ->name('by-package');
        Route::get('/{folder}/materials', [UserMaterialController::class, 'getMaterialsByFolder'])
            ->name('materials');
    });
```

### Controller Methods Baru
#### UserMaterialController
- `foldersIndex()`: Menampilkan daftar folder dengan filter
- `folderShow()`: Menampilkan detail folder dengan materi di dalamnya
- `getFoldersByPackage()`: AJAX endpoint untuk mendapatkan folder berdasarkan paket
- `getMaterialsByFolder()`: AJAX endpoint untuk mendapatkan materi dalam folder

### View Files Baru
- `resources/views/views_user/materials/folders/index.blade.php`: Tampilan utama folder
- `resources/views/views_user/materials/folders/show.blade.php`: Tampilan detail folder

## Cara Penggunaan

### 1. Untuk Siswa (User)
1. **Akses Materi**: Login dan masuk ke menu "Materi"
2. **Pilih Tampilan**: Gunakan toggle button untuk memilih "Tampilan Folder"
3. **Lihat Folder**: Klik pada folder pertemuan untuk melihat semua materi
4. **Akses Materi**: Klik pada materi individual untuk melihat atau mengunduh

### 2. Untuk Tutor
1. **Buat Folder**: (Fitur admin/tutor management perlu ditambahkan)
2. **Atur Materi**: Seret dan letakkan materi ke dalam folder
3. **Atur Urutan**: Setel nomor urut untuk folder dan materi

### 3. Untuk Admin
1. **Kelola Folder**: (Interface admin perlu ditambahkan)
2. **Atur Paket**: Kaitkan folder dengan paket ujian tertentu
3. **Publish/Unpublish**: Kontrol visibilitas folder

## Keamanan dan Akses

### Kontrol Akses
- Folder hanya dapat diakses oleh siswa yang membeli paket yang sesuai
- Verifikasi pembayaran diperlukan untuk akses penuh
- Preview mode tersedia untuk materi tanpa akses

### Middleware
- `auth`: Pengguna harus login
- `verified`: Email harus diverifikasi
- `profiled`: Profil harus dilengkapi

## Migrasi Database

### Jalankan Migrasi
```bash
php artisan migrate
```

### Seed Data (Opsional)
Buat seeder untuk data contoh folder dan materi:

```bash
php artisan make:seeder MaterialFolderSeeder
```

## Pengembangan Lanjutan

### Fitur yang Dapat Ditambahkan
1. **Admin Interface**: CRUD operations untuk folder
2. **Drag & Drop**: Interface untuk mengatur materi dalam folder
3. **Bulk Operations**: Upload multiple materi sekaligus
4. **Folder Templates**: Template standar untuk jenis pertemuan tertentu
5. **Progress Tracking**: Tracking kemajuan siswa per folder
6. **Folder Sharing**: Share folder antar paket
7. **Folder Analytics**: Statistik penggunaan folder

### API Endpoints
RESTful API untuk integrasi dengan mobile app atau sistem lain:

```
GET /api/materials/folders
GET /api/materials/folders/{id}
POST /api/materials/folders
PUT /api/materials/folders/{id}
DELETE /api/materials/folders/{id}
```

## Troubleshooting

### Common Issues
1. **Folder tidak muncul**: Pastikan user memiliki akses ke paket yang sesuai
2. **Materi tidak terload**: Periksa foreign key relationships
3. **Error permission**: Pastikan middleware sudah benar
4. **Migration error**: Pastikan tabel dependencies sudah ada

### Debug
Aktifkan debug mode dan periksa:
- Log error di `storage/logs/laravel.log`
- Network tab untuk AJAX requests
- Database query logs
- Permission dan role user

## Performance Considerations

### Optimization
1. **Eager Loading**: Gunakan `with()` untuk loading relasi
2. **Pagination**: Folder dan materi dipaginate
3. **Caching**: Cache hasil query untuk user yang sama
4. **Indexing**: Pastikan database index pada foreign keys
5. **Lazy Loading**: Load materi hanya saat folder dibuka

## Maintenance

### Regular Tasks
1. **Backup**: Backup tabel material_folders secara berkala
2. **Cleanup**: Hapus folder dan materi yang tidak digunakan
3. **Monitor**: Monitor performance query dan response time
4. **Update**: Update dependencies dan security patches

## Support

Untuk bantuan teknis atau pertanyaan implementasi, silakan hubungi tim pengembangan atau buat issue di repository.