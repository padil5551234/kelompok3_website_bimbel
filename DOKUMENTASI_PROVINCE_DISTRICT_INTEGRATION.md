# Dokumentasi Integrasi Province-District untuk Profil User

## 📋 Overview

Sistem ini mengintegrasikan data profil user dengan sistem provinsi-kabupaten Indonesia, memungkinkan pengguna untuk memilih provinsi terlebih dahulu, kemudian memilih kabupaten/kota yang terkait.

## 🏗️ Struktur Database

### 1. Tabel `kabupaten`
```sql
CREATE TABLE IF NOT EXISTS `kabupaten` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `kode_provinsi` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kabupaten_kode_unique` (`kode`)
)
```

### 2. Tabel `users_detail` (Updated)
```sql
ALTER TABLE users_detail ADD COLUMN kode_provinsi varchar(10) AFTER no_hp;
ALTER TABLE users_detail ADD COLUMN kode_kabupaten varchar(10) AFTER kode_provinsi;
ALTER TABLE users_detail ADD INDEX idx_kode_provinsi (kode_provinsi);
ALTER TABLE users_detail ADD INDEX idx_kode_kabupaten (kode_kabupaten);
```

### 3. Tabel `formasi` (Provinsi)
- Berisi data 38 provinsi Indonesia
- Kode provinsi 2 digit (misal: 32 = Jawa Barat)
- Nama provinsi lengkap

## 📁 Struktur File

### Models
- `app/Models/Kabupaten.php` - Model untuk akses tabel kabupaten
- `app/Models/UsersDetail.php` - Updated dengan relasi province-district
- `app/Models/Formasi.php` - Model untuk akses tabel provinsi

### Controllers
- `app/Http/Controllers/Api/WilayahController.php` - API endpoints
- `app/Http/Controllers/ProfileDetailController.php` - Controller untuk profil

### Routes
- `routes/api.php` - API routes untuk wilayah
- `routes/web.php` - Web routes untuk profil

### Views
- `resources/views/profile/detail-edit.blade.php` - Form profil dengan dropdown

## 🔗 Koneksi Data

### Relationship Flow
```
User -> UsersDetail -> kode_provinsi -> Formasi (Provinsi)
                 -> kode_kabupaten -> Kabupaten -> kode_provinsi -> Formasi
```

### Data Integrity
- Validasi: kabupaten harus milik provinsi yang dipilih
- Auto-clear: jika provinsi berubah, kabupaten akan di-reset
- Referential integrity melalui foreign key relationships

## 🌐 API Endpoints

### 1. Get Provinces
```
GET /api/wilayah/provinsi
Response: {
  "success": true,
  "data": [
    {"kode": "11", "nama": "Provinsi Aceh"},
    {"kode": "12", "nama": "Provinsi Sumatera Utara"},
    ...
  ]
}
```

### 2. Get Districts by Province
```
GET /api/wilayah/kabupaten?kode_provinsi=32
Response: {
  "success": true,
  "data": [
    {"kode": "3201", "nama": "Kabupaten Bogor"},
    {"kode": "3202", "nama": "Kabupaten Cianjur"},
    ...
  ]
}
```

### 3. Get District Info
```
GET /api/wilayah/kabupaten-by-kode?kode=3201
Response: {
  "success": true,
  "data": {
    "kode": "3201",
    "kode_provinsi": "32",
    "nama": "Kabupaten Bogor"
  }
}
```

### 4. Search Districts
```
GET /api/wilayah/search-kabupaten?q=bogor&kode_provinsi=32
Response: {
  "success": true,
  "data": [
    {"kode": "3201", "nama": "Kabupaten Bogor"}
  ]
}
```

## 🖥️ User Interface

### Form Features
1. **Dynamic Dropdown**: Kabupaten list diupdate otomatis saat provinsi dipilih
2. **Loading State**: Visual feedback saat memuat data kabupaten
3. **Validation**: Required fields dengan error handling
4. **Auto-populate**: Existing data di-load saat form dibuka
5. **Responsive Design**: Mobile-friendly interface

### JavaScript Functionality
```javascript
// Event listener untuk perubahan provinsi
provinsiSelect.addEventListener('change', function() {
    const kodeProvinsi = this.value;
    loadKabupaten(kodeProvinsi);
});

// Function untuk load kabupaten
function loadKabupaten(kodeProvinsi, selectedKabupaten = '') {
    fetch(`/profile/detail/kabupaten?kode_provinsi=${kodeProvinsi}`)
        .then(response => response.json())
        .then(data => {
            // Update dropdown kabupaten
        });
}
```

## 🚀 Installation & Setup

### 1. Database Migration
```bash
# Jalankan migration untuk update tabel users_detail
php artisan migrate

# Atau jalankan script test untuk setup
php test_province_district_integration.php
```

### 2. Seed Data (Jika belum ada)
```bash
# Restore data kabupaten (pilih salah satu)
mysql -u username -p database_name < restore_kabupaten_final_fix.sql
# atau
php restore_kabupaten_formasi.php
```

### 3. Test System
```bash
# Test integrasi
php test_province_district_integration.php
```

## 📝 Usage

### 1. Access Profile Form
```
URL: /profile/detail
Route: profile.detail.edit
```

### 2. User Flow
1. User memilih provinsi dari dropdown
2. Sistem otomatis memuat daftar kabupaten untuk provinsi tersebut
3. User memilih kabupaten dari dropdown yang sudah di-filter
4. User mengisi form lainnya (HP, kecamatan, sekolah, dll)
5. User menyimpan data

### 3. Data Validation
- Provinsi: Wajib dipilih
- Kabupaten: Wajib dipilih (akan di-validasi terhadap provinsi)
- HP: Wajib diisi
- Field lain: Opsional

## 🔍 Testing

### Test Cases
1. **Load Provinces**: Verify all 38 provinces loaded
2. **Filter Districts**: Verify districts filtered by selected province
3. **Data Persistence**: Verify user data saved correctly
4. **Form Validation**: Verify required field validation
5. **API Response**: Verify JSON response format
6. **Relationship**: Verify province-district connection

### Test Commands
```bash
# Test API endpoints
curl -X GET "http://your-domain/api/wilayah/provinsi"
curl -X GET "http://your-domain/api/wilayah/kabupaten?kode_provinsi=32"

# Test web interface
# Navigate to /profile/detail
```

## 📊 Data Statistics

- **Total Provinces**: 38 provinsi (exclude 00, 01)
- **Total Districts**: 514 kabupaten/kota
- **Data Source**: BPS (Badan Pusat Statistik)
- **Collation**: utf8mb4_unicode_ci
- **Encoding**: UTF-8

## 🔧 Customization

### Adding New Districts
```php
// Via Model
Kabupaten::create([
    'kode' => '9999',
    'kode_provinsi' => '99',
    'nama' => 'Kabupaten Baru'
]);
```

### Custom Validation Rules
```php
// In ProfileDetailController
$request->validate([
    'kode_provinsi' => ['required', 'string', 'size:2', Rule::exists('formasi', 'kode')],
    'kode_kabupaten' => ['nullable', 'string', 'size:4', Rule::exists('kabupaten', 'kode')],
]);
```

## 🛡️ Security Features

1. **Input Validation**: Server-side validation untuk semua input
2. **CSRF Protection**: Laravel CSRF tokens
3. **SQL Injection Prevention**: Using Eloquent ORM
4. **XSS Protection**: Input sanitization
5. **Authorization**: Middleware authentication

## 📈 Performance

### Optimizations
1. **Database Indexes**: Index pada kode_provinsi dan kode_kabupaten
2. **Eager Loading**: Relasi dimuat secara efisien
3. **Caching**: API responses bisa di-cache untuk performance
4. **AJAX Loading**: District data dimuat secara dinamis

### Caching Strategy (Opsional)
```php
// Cache provinces untuk 24 jam
Cache::remember('provinces', 86400, function() {
    return Formasi::where('kode', '!=', '00')
                  ->where('kode', '!=', '01')
                  ->orderBy('nama')
                  ->get(['kode', 'nama']);
});
```

## 🐛 Troubleshooting

### Common Issues

1. **Kabupaten tidak muncul**
   - Pastikan data kabupaten sudah terisi
   - Check koneksi database
   - Verify JavaScript console errors

2. **Form tidak submit**
   - Check CSRF token
   - Verify required field validation
   - Check server error logs

3. **API error**
   - Verify route registration
   - Check middleware configuration
   - Verify controller namespace

### Debug Commands
```bash
# Check routes
php artisan route:list | grep profile
php artisan route:list | grep wilayah

# Check models
php artisan tinker
>>> App\Models\Kabupaten::count();
>>> App\Models\Formasi::count();

# Check database
mysql -u username -p -e "SELECT COUNT(*) FROM kabupaten;"
```

## 📞 Support

Untuk bantuan atau pertanyaan:
1. Check dokumentasi ini terlebih dahulu
2. Review error logs
3. Test dengan data sample
4. Check browser developer tools untuk frontend issues

## 🔄 Updates & Maintenance

### Regular Tasks
1. **Update Data**: Periodically sync with BPS data
2. **Performance Check**: Monitor query performance
3. **Security Audit**: Review security measures
4. **User Feedback**: Collect user experience feedback

### Version History
- **v1.0**: Initial implementation with basic province-district integration
- **v1.1**: Added API endpoints and improved validation
- **v1.2**: Enhanced UI with dynamic dropdown and loading states

---

**Status**: ✅ Ready for Production
**Last Updated**: December 2024
**Compatibility**: Laravel 8+, MySQL 5.7+