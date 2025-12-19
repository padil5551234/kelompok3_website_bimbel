# 🎓 DinasSolution - Platform Bimbel Kedinasan Terlengkap

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg?style=flat-square)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg?style=flat-square)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg?style=flat-square)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

## 📋 Daftar Isi

- [Overview Proyek](#-overview-proyek)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Struktur Folder](#-struktur-folder)
- [Prasyarat Sistem](#-prasyarat-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Database Schema](#-database-schema)
- [API Documentation](#-api-documentation)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [User Roles & Permissions](#-user-roles--permissions)
- [Payment System](#-payment-system)
- [Email Notifications](#-email-notifications)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Troubleshooting](#-troubleshooting)
- [Security](#-security)
- [Performance](#-performance)
- [Changelog](#-changelog)
- [Lisensi](#-lisensi)

---

## 🎯 Overview Proyek

**DinasSolution** adalah platform bimbel kedinasan terbaik di Indonesia yang dibangun dengan Laravel 10. Sistem ini dirancang khusus untuk membantu peserta seleksi masuk Sekolah Tinggi Ilmu Statistik (STIS) dan sekolah kedinasan lainnya melalui:

- **Tryout Online** dengan sistem Computer Assisted Test (CAT)
- **Pembelajaran Interaktif** dengan video dan materi berkualitas
- **Monitoring Progress** belajar secara real-time
- **Sistem Pembayaran** terintegrasi dengan Midtrans
- **Kelas Online** dengan tentor berpengalaman
- **Analitik Nilai** dan laporan progress

### 🎯 Target User
- **Peserta Tes Kedinasan**: STIS, IPDN, STIN, dan sekolah kedinasan lainnya
- **Mahasiswa STIS**: Sebagai tentor dan creator konten
- **Admin**: Pengelola platform dan moderator

---

## ✨ Fitur Utama

### 🔐 Multi-Role Authentication System
- ✅ Role-based access control (Admin, Tutor, User)
- ✅ Google OAuth integration
- ✅ Email verification
- ✅ Password reset functionality
- ✅ Session management

### 📚 Course Management
- ✅ **Paket Ujian** dengan kategori dan level
- ✅ **Chapter-based Learning** materials
- ✅ **YouTube Integration** untuk video pembelajaran
- ✅ **File Upload** untuk materi PDF dan dokumen
- ✅ **Progress Tracking** per user

### 🎯 Exam System
- ✅ **Computer Assisted Test (CAT)** simulation
- ✅ **Multiple Choice Questions** dengan support gambar
- ✅ **Timer System** dengan auto-submit
- ✅ **Scoring Algorithm** otomatis
- ✅ **Result Analysis** dengan ranking

### 💳 Payment Integration
- ✅ **Midtrans Payment Gateway** (Credit Card, Bank Transfer, E-wallet)
- ✅ **Manual Payment** dengan upload bukti transfer
- ✅ **Payment Verification** system
- ✅ **Email Notifications** untuk setiap status pembayaran
- ✅ **Voucher/Discount** system

### 📧 Email Notification System
- ✅ **Payment Success** notifications
- ✅ **Payment Failed** alerts
- ✅ **Verification Pending** reminders
- ✅ **Admin Approval** notifications
- ✅ **Beautiful HTML Templates** dengan styling konsisten

### 👨‍🏫 Tutor Features
- ✅ **Live Class Scheduling**
- ✅ **Material Upload** dengan kategori
- ✅ **Question Bank Management**
- ✅ **Student Progress Monitoring**
- ✅ **Batch and Subject Assignment**

### 📊 Admin Dashboard
- ✅ **User Management** (CRUD operations)
- ✅ **Payment Monitoring** dan verification
- ✅ **Content Management** (Courses, Materials, Articles)
- ✅ **Analytics & Reports**
- ✅ **System Configuration**

### 📱 Responsive Design
- ✅ **Mobile-First** approach
- ✅ **Bootstrap 5** integration
- ✅ **AdminLTE** untuk admin panel
- ✅ **Custom CSS** untuk user interface

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    FRONTEND LAYER                          │
├─────────────────────────────────────────────────────────────┤
│  User Interface    │  Admin Panel    │  Tutor Dashboard    │
│  - Landing Page    │  - Statistics   │  - Live Classes     │
│  - User Dashboard  │  - User Mgmt    │  - Materials        │
│  - Exam Interface  │  - Content Mgmt │  - Question Bank    │
│  - Payment Flow    │  - Payment Verif│  - Student Monitor  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                   APPLICATION LAYER                         │
├─────────────────────────────────────────────────────────────┤
│  Controllers (MVC Pattern)                                 │
│  ├── User Controllers  │  Admin Controllers                │
│  ├── Tutor Controllers │  Auth Controllers                 │
│  └── API Controllers   │  Payment Controllers              │
│                                                           │
│  Middleware & Policies                                     │
│  ├── Authentication    │  Authorization                    │
│  ├── Role Permission   │  API Rate Limiting               │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    DATA LAYER                              │
├─────────────────────────────────────────────────────────────┤
│  Models & Relationships                                    │
│  ├── User (Multi-role)    │  Payment & Transactions        │
│  ├── Course & Materials   │  Exam & Questions              │
│  ├── Live Classes        │  Progress & Analytics          │
│                                                           │
│  Database: MySQL 8.0+                                       │
│  Cache: Redis/File                                        │
│  Queue: Database/Redis                                     │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                 EXTERNAL SERVICES                          │
├─────────────────────────────────────────────────────────────┤
│  Payment: Midtrans           │  Email: SMTP/Gmail         │
│  OAuth: Google              │  Storage: Local/Cloud       │
│  CDN: Static Assets         │  Analytics: Custom         │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Struktur Folder

```
project-root/
├── 📂 app/
│   ├── 📂 Http/
│   │   ├── 📂 Controllers/
│   │   │   ├── 📂 Admin/           # Admin panel controllers
│   │   │   ├── 📂 Tutor/            # Tutor dashboard controllers
│   │   │   ├── 📂 Auth/             # Authentication controllers
│   │   │   ├── 📂 Api/              # API endpoints
│   │   │   └── 📄 *.php             # Main controllers
│   │   ├── 📂 Middleware/           # Custom middleware
│   │   └── 📂 Requests/             # Form request validation
│   ├── 📂 Models/                   # Eloquent models
│   │   ├── 📄 User.php             # Multi-role user model
│   │   ├── 📄 PaketUjian.php       # Exam packages
│   │   ├── 📄 Material.php         # Learning materials
│   │   ├── 📄 Ujian.php            # Exam instances
│   │   └── 📄 *.php                # Other models
│   ├── 📂 Mail/                     # Email classes
│   │   ├── 📄 PembelianSukses.php
│   │   ├── 📄 PembelianGagal.php
│   │   ├── 📄 PembelianPendingVerifikasi.php
│   │   └── 📄 PembelianTerverifikasi.php
│   ├── 📂 Policies/                 # Authorization policies
│   └── 📂 Providers/                # Service providers
├── 📂 database/
│   ├── 📂 migrations/               # Database migrations
│   ├── 📂 seeders/                  # Database seeders
│   └── 📂 factories/                # Model factories
├── 📂 resources/
│   ├── 📂 views/
│   │   ├── 📂 layouts/              # Layout templates
│   │   ├── 📂 views_user/           # User interface views
│   │   ├── 📂 admin/                # Admin panel views
│   │   ├── 📂 mail/                 # Email templates
│   │   └── 📂 *.blade.php           # Blade templates
│   └── 📂 lang/                     # Localization files
├── 📂 public/
│   ├── 📂 assets/                   # Static assets
│   │   ├── 📂 css/                  # Stylesheets
│   │   ├── 📂 js/                   # JavaScript files
│   │   └── 📂 images/               # Image assets
│   └── 📂 storage/                  # Symlink to storage/app/public
├── 📂 routes/
│   ├── 📄 web.php                   # Web routes
│   ├── 📄 api.php                   # API routes
│   └── 📄 integrated-admin.php      # Admin system routes
├── 📂 storage/
│   ├── 📂 app/
│   │   ├── 📂 public/               # Public storage files
│   │   └── 📂 private/              # Private storage files
│   └── 📂 logs/                     # Application logs
├── 📂 vendor/                       # Composer dependencies
├── 📄 .env                         # Environment configuration
├── 📄 .env.example                 # Environment template
├── 📄 composer.json                # PHP dependencies
├── 📄 package.json                 # Node.js dependencies
└── 📄 README.md                    # Project documentation
```

---

## 🔧 Prasyarat Sistem

### Server Requirements
- **PHP**: 8.1 atau lebih tinggi
- **MySQL**: 8.0+ atau MariaDB 10.3+
- **Composer**: 2.0+ (untuk PHP dependencies)
- **Node.js**: 16+ dan NPM (untuk frontend assets)
- **Web Server**: Apache 2.4+ atau Nginx 1.18+

### PHP Extensions Required
```bash
# Pastikan ekstensi berikut terinstall:
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
```

### Server Specifications
- **RAM**: Minimum 2GB, Recommended 4GB+
- **Storage**: Minimum 10GB free space
- **Bandwidth**: 100Mbps+ untuk production
- **SSL Certificate**: Required untuk production

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
# Clone project
git clone https://github.com/your-username/dinasolution.git
cd dinasolution

# Atau download dan extract ZIP
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
npm install

# Build frontend assets
npm run build
```

### 3. Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Buat database MySQL
# mysql -u root -p
# CREATE DATABASE dinasolution CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Edit .env file dengan database credentials
# Jalankan migrations
php artisan migrate

# Seed initial data (optional)
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage symlink
php artisan storage:link

# Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## ⚙️ Konfigurasi Environment

Edit file `.env` dengan konfigurasi berikut:

```env
# Application Configuration
APP_NAME="DinasSolution"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dinasolution
DB_USERNAME=your_db_username
DB_PASSWORD=your_secure_password

# Cache & Session Configuration
CACHE_DRIVER=file
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database

# Mail Configuration (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dinasolution.com
MAIL_FROM_NAME="${APP_NAME}"

# Payment Gateway (Midtrans)
MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback

# File Storage
FILESYSTEM_DISK=public

# Security
BCRYPT_ROUNDS=12
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com

# Timezone
APP_TIMEZONE=Asia/Jakarta
```

---

## 🏃‍♂️ Menjalankan Aplikasi

### Development Environment
```bash
# Jalankan development server
php artisan serve

# Akses di browser: http://localhost:8000

# Atau gunakan Laravel Sail (Docker)
./vendor/bin/sail up -d
```

### Production Environment
```bash
# Clear all caches
php artisan optimize:clear

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set production permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### Queue Worker (untuk background jobs)
```bash
# Jalankan queue worker untuk email notifications
php artisan queue:work --daemon

# Atau untuk development
php artisan queue:work
```

### Cron Jobs (untuk scheduled tasks)
```bash
# Edit crontab
crontab -e

# Tambahkan baris berikut:
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🗄️ Database Schema

### Core Tables

#### Users Table
```sql
users:
- id (UUID, Primary Key)
- name (String)
- email (String, Unique)
- email_verified_at (Timestamp)
- password (Hashed String)
- role (Enum: admin, tutor, user)
- avatar (String, Path to image)
- is_active (Boolean)
- created_at, updated_at
```

#### Paket Ujian (Exam Packages)
```sql
paket_ujian:
- id (UUID, Primary Key)
- nama (String)
- deskripsi (Text)
- kategori (String)
- level (String: dasar, menengah, lanjut)
- harga (Decimal)
- waktu_mulai (Timestamp)
- waktu_akhir (Timestamp)
- is_active (Boolean)
- whatsapp_group_link (String)
- created_at, updated_at
```

#### Materials Table
```sql
materials:
- id (UUID, Primary Key)
- batch_id (Foreign Key)
- tutor_id (Foreign Key)
- title (String)
- description (Text)
- type (Enum: youtube, pdf, video, link)
- mapel (String)
- chapter_number (Integer)
- chapter_title (String)
- material_order (Integer)
- youtube_url (String)
- file_path (String)
- external_link (String)
- is_public (Boolean)
- is_featured (Boolean)
- views_count (Integer)
- downloads_count (Integer)
- created_at, updated_at
```

#### Ujian (Exam Instances)
```sql
ujian:
- id (UUID, Primary Key)
- paket_ujian_id (Foreign Key)
- nama (String)
- deskripsi (Text)
- waktu_mulai (Timestamp)
- waktu_akhir (Timestamp)
- tampil_nilai (Enum: 0,1,2,3)
- waktu_pengumuman (Timestamp)
- is_active (Boolean)
- created_at, updated_at
```

#### Questions & Answers
```sql
soal:
- id (UUID, Primary Key)
- ujian_id (Foreign Key)
- pertanyaan (Text)
- gambar (String, Path to image)
- tipe_soal (Enum: pg, essay)
- bobot (Decimal)
- urutan (Integer)
- is_active (Boolean)
- created_at, updated_at

jawaban:
- id (UUID, Primary Key)
- soal_id (Foreign Key)
- jawaban_text (Text)
- is_correct (Boolean)
- urutan (Integer)
- created_at, updated_at
```

#### User Exam Results
```sql
ujian_user:
- id (UUID, Primary Key)
- ujian_id (Foreign Key)
- user_id (Foreign Key)
- status (Enum: 0,1,2,3)
- nilai (Decimal)
- ranking (Integer)
- waktu_mulai (Timestamp)
- waktu_selesai (Timestamp)
- is_first (Boolean)
- created_at, updated_at

jawaban_peserta:
- id (UUID, Primary Key)
- ujian_user_id (Foreign Key)
- soal_id (Foreign Key)
- jawaban_id (Foreign Key) -- nullable untuk essay
- jawaban_text (Text) -- nullable untuk pg
- is_correct (Boolean)
- created_at, updated_at
```

#### Payment System
```sql
pembelian:
- id (UUID, Primary Key)
- user_id (Foreign Key)
- paket_ujian_id (Foreign Key)
- jumlah (Decimal)
- status (Enum: pending, sukses, gagal, verifikasi)
- bukti_transfer (String, Path to image)
- metode_pembayaran (String)
- transaction_id (String)
- midtrans_order_id (String)
- midtrans_transaction_id (String)
- created_at, updated_at
```

---

## 🔌 API Documentation

### Authentication Endpoints

#### User Registration
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}

Response: 201 Created
{
    "user": { ... },
    "token": "Bearer token_here"
}
```

#### User Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}

Response: 200 OK
{
    "user": { ... },
    "token": "Bearer token_here"
}
```

### Course & Material Endpoints

#### Get Available Packages
```http
GET /api/packages
Authorization: Bearer {token}

Response: 200 OK
{
    "data": [
        {
            "id": "uuid",
            "nama": "Paket Premium STIS",
            "deskripsi": "Description...",
            "kategori": "Matematika",
            "level": "Lanjut",
            "harga": 500000,
            "waktu_mulai": "2024-01-01T00:00:00Z",
            "waktu_akhir": "2024-12-31T23:59:59Z"
        }
    ]
}
```

#### Get User Materials
```http
GET /api/materials/my
Authorization: Bearer {token}

Response: 200 OK
{
    "data": [
        {
            "id": "uuid",
            "title": "Materi Bab 1",
            "description": "Description...",
            "type": "youtube",
            "youtube_url": "https://youtube.com/watch?v=...",
            "chapter_title": "BAB 1: Aljabar Dasar",
            "is_completed": false
        }
    ]
}
```

### Exam Endpoints

#### Get Available Exams
```http
GET /api/exams
Authorization: Bearer {token}

Response: 200 OK
{
    "data": [
        {
            "id": "uuid",
            "nama": "Tryout STIS Gelombang 1",
            "deskripsi": "Description...",
            "waktu_mulai": "2024-01-01T00:00:00Z",
            "waktu_akhir": "2024-01-31T23:59:59Z",
            "can_access": true
        }
    ]
}
```

#### Start Exam
```http
POST /api/exams/{id}/start
Authorization: Bearer {token}

Response: 200 OK
{
    "ujian_user_id": "uuid",
    "soal": [
        {
            "id": "uuid",
            "pertanyaan": "Question text...",
            "gambar": "path/to/image.jpg",
            "jawaban": [
                {
                    "id": "uuid",
                    "jawaban_text": "Option A",
                    "urutan": 1
                }
            ]
        }
    ]
}
```

#### Submit Answer
```http
POST /api/exams/{id}/submit
Authorization: Bearer {token}
Content-Type: application/json

{
    "ujian_user_id": "uuid",
    "jawaban": [
        {
            "soal_id": "uuid",
            "jawaban_id": "uuid", // untuk pilihan ganda
            "jawaban_text": null  // untuk essay
        }
    ]
}

Response: 200 OK
{
    "message": "Jawaban berhasil disimpan",
    "can_submit": true
}
```

### Payment Endpoints

#### Create Payment
```http
POST /api/payments
Authorization: Bearer {token}
Content-Type: application/json

{
    "paket_id": "uuid",
    "metode_pembayaran": "midtrans"
}

Response: 201 Created
{
    "pembelian_id": "uuid",
    "payment_url": "https://app.sandbox.midtrans.com/...",
    "transaction_id": "transaction_123"
}
```

#### Upload Payment Proof
```http
POST /api/payments/{id}/upload-proof
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "bukti_transfer": [file upload]
}

Response: 200 OK
{
    "message": "Bukti transfer berhasil diupload"
}
```

---

## 📖 Panduan Penggunaan

### 🔐 Untuk User (Peserta)

#### 1. Registrasi dan Login
1. Kunjungi halaman utama: `https://yourdomain.com`
2. Klik **"Daftar"** untuk membuat akun baru
3. Isi form registrasi dengan data yang valid
4. Cek email untuk verifikasi akun
5. Login dengan email dan password

#### 2. Beli Paket Ujian
1. Login ke akun Anda
2. Browse paket ujian yang tersedia
3. Pilih paket sesuai kebutuhan dan budget
4. Klik **"Beli Paket"**
5. Pilih metode pembayaran:
   - **Midtrans**: Bayar langsung dengan kartu kredit, transfer bank, atau e-wallet
   - **Manual Transfer**: Upload bukti transfer setelah transfer ke rekening kami
6. Konfirmasi pembayaran
7. Cek email untuk notifikasi status pembayaran

#### 3. Akses Materi Pembelajaran
1. Setelah pembayaran sukses, paket akan aktif
2. Masuk ke **"Materi Saya"** dari dashboard
3. Pilih materi berdasarkan bab/chapter
4. Akses video pembelajaran YouTube
5. Download materi PDF jika tersedia
6. Track progress belajar Anda

#### 4. Mengikuti Tryout
1. Masuk ke menu **"Tryout"**
2. Pilih tryout yang tersedia dan belum dikerjakan
3. Klik **"Mulai Ujian"**
4. Baca instruksi dengan teliti
5. Kerjakan soal secara berurutan
6. Gunakan fitur **"Ragu-ragu"** untuk menandai soal yang belum yakin
7. Monitor waktu tersisa di timer
8. Submit jawaban sebelum waktu habis
9. Lihat hasil dan ranking setelah pengumuman

#### 5. Melihat Hasil dan Progress
1. Masuk ke menu **"Nilai"** untuk melihat hasil tryout
2. Lihat **"Raport"** untuk analisis progress belajar
3. Cek ranking dan percentile score
4. Download laporan hasil dalam format PDF

### 👨‍🏫 Untuk Tutor

#### 1. Setup Profil Tutor
1. Login dengan akun tutor
2. Lengkapi profil dan specialisasi
3. Upload foto profil dan bio
4. Setup kontak WhatsApp untuk komunikasi

#### 2. Membuat Live Class
1. Masuk ke dashboard tutor
2. Klik **"Buat Kelas Online"**
3. Isi detail kelas:
   - Judul dan deskripsi
   - Jadwal dan durasi
   - Target peserta
   - Materi yang akan dibahas
4. Generate link meeting (Zoom/Google Meet)
5. Notifikasi otomatis ke peserta terdaftar

#### 3. Upload Materi
1. Klik **"Upload Materi"**
2. Pilih kategori dan bab
3. Upload materi dalam berbagai format:
   - **YouTube Video**: Masukkan URL video
   - **PDF**: Upload file dokumen
   - **Link Eksternal**: Tambah referensi website
4. Isi deskripsi dan tag untuk kemudahan pencarian
5. Set visibility (public/private)

#### 4. Management Question Bank
1. Masuk ke **"Bank Soal"**
2. Tambah soal baru dengan format:
   - Pertanyaan teks dan gambar
   - Pilihan jawaban (untuk PG)
   - Kunci jawaban dan pembetulan
   - Bobot nilai
3. Import soal dari Excel (template tersedia)
4. Kategorisasi soal berdasarkan topik

#### 5. Monitor Progress Siswa
1. Lihat dashboard progress siswa
2. Analisis hasil tryout per siswa
3. Identifikasi siswa yang perlu bantuan
4. Generate laporan progress

### 🔧 Untuk Admin

#### 1. User Management
1. Masuk ke admin panel: `/admin`
2. **User List**: Lihat semua user yang terdaftar
3. **Add User**: Tambah user baru (admin/tutor)
4. **Edit User**: Update profil dan role user
5. **Deactivate/Activate**: Nonaktifkan akun bermasalah
6. **Reset Password**: Reset password user

#### 2. Content Management
1. **Paket Ujian**: 
   - Buat paket ujian baru
   - Set harga dan periode aktif
   - Upload deskripsi dan gambar
   - Configure WhatsApp group link
2. **Materials**: 
   - Review materi yang diupload tutor
   - Set materi sebagai featured
   - Hapus konten yang tidak sesuai
3. **Articles**: 
   - Tulis artikel blog
   - Upload featured image
   - Set kategori dan tag

#### 3. Payment Verification
1. **Payment Dashboard**: Monitor semua transaksi
2. **Pending Verification**: Cek bukti transfer
3. **Manual Verification**: 
   - Approve/reject pembayaran manual
   - Berikan notifikasi ke user
4. **Payment Reports**: Lihat laporan pendapatan

#### 4. System Configuration
1. **General Settings**: 
   - Update nama aplikasi dan kontak
   - Set timezone dan bahasa
2. **Email Configuration**: 
   - Setup SMTP untuk notifikasi
   - Test email delivery
3. **Payment Settings**: 
   - Update Midtrans keys
   - Set payment methods
4. **Backup & Maintenance**: 
   - Backup database rutin
   - Monitor system logs

---

## 👥 User Roles & Permissions

### 🔴 Admin Role
**Permissions:**
- ✅ Full system access
- ✅ User management (create, edit, delete)
- ✅ Content management (courses, materials, articles)
- ✅ Payment verification and monitoring
- ✅ System configuration
- ✅ Analytics and reports
- ✅ FAQ management
- ✅ Announcement system

**Access URLs:**
- `/admin` - Admin dashboard
- `/admin/users` - User management
- `/admin/content` - `/admin/payments Content management
-` - Payment monitoring

### 🟠 Tutor Role
**Permissions:**
- ✅ Create and manage live classes
- ✅ Upload and edit learning materials
- ✅ Manage question bank
- ✅ Monitor student progress
- ✅ View class analytics
- ✅ Communicate with students

**Access URLs:**
- `/tutor` - Tutor dashboard
- `/tutor/classes` - Live class management
- `/tutor/materials` - Material management
- `/tutor/questions` - Question bank

### 🟢 User Role
**Permissions:**
- ✅ Purchase exam packages
- ✅ Access purchased materials
- ✅ Take exams and view results
- ✅ View personal progress and reports
- ✅ Join live classes (if purchased)
- ✅ Contact support

**Access URLs:**
- `/dashboard` - User dashboard
- `/tryout` - Exam interface
- `/materials` - Learning materials
- `/nilai` - Results and reports

---

## 💳 Payment System

### 🔄 Payment Flow

```
User Purchase Flow:
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│ User Pilih  │───▶│ Pilih Metode│───▶│ Konfirmasi  │
│   Paket     │    │ Pembayaran  │    │  Pembayaran │
└─────────────┘    └─────────────┘    └─────────────┘
                                              │
                                              ▼
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   Kirim     │◀───│   Midtrans  │◀───│Generate     │
│ Notifikasi  │    │    API      │    │Order ID     │
│    Email    │    └─────────────┘    └─────────────┘
└─────────────┘
        │
        ▼
┌─────────────┐
│  Simpan     │
│Transaksi DB │
└─────────────┘
```

### 💰 Supported Payment Methods

#### 1. Midtrans Payment Gateway
- **Credit Card**: Visa, Mastercard, JCB
- **Bank Transfer**: BCA, BNI, BRI, Mandiri, dll
- **E-Wallet**: GoPay, OVO, DANA, LinkAja
- **QRIS**: Pembayaran dengan QR Code
- **VA**: Virtual Account berbagai bank

#### 2. Manual Transfer
- Upload bukti transfer
- Verifikasi manual oleh admin
- Notifikasi email otomatis
- Aktivasi paket setelah verifikasi

### 📧 Payment Email Notifications

#### Email Templates:
1. **PembelianSukses** - Pembayaran berhasil via Midtrans
2. **PembelianGagal** - Pembayaran gagal/expired
3. **PembelianPendingVerifikasi** - Menunggu verifikasi bukti transfer
4. **PembelianTerverifikasi** - Pembayaran berhasil diverifikasi

#### Email Features:
- ✅ Beautiful HTML templates dengan branding
- ✅ Responsive design untuk mobile
- ✅ Informasi detail transaksi
- ✅ Link WhatsApp untuk support
- ✅ Langkah selanjutnya yang jelas

---

## 📧 Email Notifications

### 📨 Email Types

#### 1. Welcome Email
```html
Subject: Selamat datang di DinasSolution, {name}!

Hi {name},

Terima kasih telah bergabung dengan DinasSolution - platform bimbel kedinasan terbaik di Indonesia.

🚀 Yang bisa Anda lakukan sekarang:
• Lihat paket ujian yang tersedia
• Beli paket sesuai kebutuhan
• Mulai belajar dengan materi berkualitas
• Ikuti tryout online

Selamat belajar dan sukses masuk sekolah kedinasan!
```

#### 2. Payment Success
```html
Subject: ✅ Pembayaran Berhasil - Paket {package_name}

Hi {name},

Pembayaran Anda telah berhasil!

📋 Detail Transaksi:
• Paket: {package_name}
• Jumlah: Rp {amount}
• Tanggal: {date}
• Transaction ID: {transaction_id}

🎯 Langkah Selanjutnya:
• Akses materi di "Materi Saya"
• Bergabung dengan grup WhatsApp: {whatsapp_link}
• Persiapkan diri untuk tryout

Terima kasih telah mempercayai DinasSolution!
```

#### 3. Payment Failed
```html
Subject: ❌ Pembayaran Gagal - {package_name}

Hi {name},

Maaf, pembayaran Anda tidak berhasil diproses.

🔄 Yang bisa Anda lakukan:
• Coba metode pembayaran lain
• Hubungi customer service kami
• Atau coba lagi nanti

💬 Butuh bantuan? Hubungi kami:
• WhatsApp: {whatsapp_number}
• Email: {support_email}

Kami siap membantu Anda!
```

### 📋 Email Configuration

#### SMTP Setup (Gmail)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dinasolution.com
MAIL_FROM_NAME="DinasSolution"
```

#### Custom Email Service
```php
// config/mail.php
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'timeout' => null,
        'local_domain' => env('MAIL_EHLO_DOMAIN'),
    ],
],
```

---

## 🧪 Testing

### 📋 Test User Accounts

#### Admin Account
```
Email: admin@dinasolution.com
Password: admin2024
Role: Administrator
Access: Full system access
```

#### Tutor Account
```
Email: tutor@dinasolution.com
Password: tutor2024
Role: Tutor
Access: Live classes, materials, questions
```

#### User Account
```
Email: user@dinasolution.com
Password: user2024
Role: User
Access: Exams, materials (purchased)
```

### 🧪 Testing Scenarios

#### 1. User Registration & Login
```bash
# Test registration
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Test login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

#### 2. Purchase Flow Testing
```bash
# Test package purchase
curl -X POST http://localhost:8000/api/payments \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "paket_id": "package-uuid",
    "metode_pembayaran": "midtrans"
  }'
```

#### 3. Exam Flow Testing
```bash
# Test start exam
curl -X POST http://localhost:8000/api/exams/{id}/start \
  -H "Authorization: Bearer {token}"

# Test submit answer
curl -X POST http://localhost:8000/api/exams/{id}/submit \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "ujian_user_id": "exam-user-uuid",
    "jawaban": [
      {
        "soal_id": "question-uuid",
        "jawaban_id": "answer-uuid"
      }
    ]
  }'
```

### 🔧 Unit Testing

#### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test tests/Feature/PaymentTest.php
```

#### Test Example
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PaketUjian;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_package()
    {
        $user = User::factory()->create();
        $package = PaketUjian::factory()->create();

        $response = $this->actingAs($user)
            ->post('/api/payments', [
                'paket_id' => $package->id,
                'metode_pembayaran' => 'midtrans'
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'pembelian_id',
                'payment_url',
                'transaction_id'
            ]);
    }
}
```

---

## 🚀 Deployment

### 📋 Production Checklist

#### Pre-Deployment
- [ ] **Environment Variables**: Pastikan `.env` production-ready
- [ ] **Database**: Backup dan migrate ke production database
- [ ] **SSL Certificate**: Install dan configure SSL
- [ ] **Domain**: Point domain ke production server
- [ ] **Dependencies**: Install production dependencies

#### Deployment Steps

#### 1. Server Setup (Ubuntu/Debian)
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.1+
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml php8.1-curl php8.1-zip php8.1-mbstring php8.1-bcmath

# Install MySQL
sudo apt install mysql-server
sudo mysql_secure_installation

# Install Nginx
sudo apt install nginx

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

#### 2. Project Deployment
```bash
# Clone project
cd /var/www
sudo git clone https://github.com/your-username/dinasolution.git
sudo chown -R www-data:www-data dinasolution
cd dinasolution

# Install dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data npm install
sudo -u www-data npm run build

# Setup environment
sudo -u www-data cp .env.example .env
sudo -u www-data php artisan key:generate

# Database setup
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan db:seed --force

# Storage setup
sudo -u www-data php artisan storage:link
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Set permissions
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
```

#### 3. Nginx Configuration
```nginx
# /etc/nginx/sites-available/dinasolution
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/dinasolution/public;

    index index.php index.html index.htm;

    # SSL Configuration
    ssl_certificate /path/to/your/certificate.crt;
    ssl_certificate_key /path/to/your/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    ssl_prefer_server_ciphers off;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Laravel specific
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Static files caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Storage files
    location /storage/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;
}
```

#### 4. Enable Site
```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/dinasolution /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Enable PHP-FPM
sudo systemctl enable php8.1-fpm
sudo systemctl start php8.1-fpm

# Enable MySQL
sudo systemctl enable mysql
sudo systemctl start mysql
```

#### 5. SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo crontab -e
# Tambahkan:
0 12 * * * /usr/bin/certbot renew --quiet
```

#### 6. Monitoring & Maintenance
```bash
# Setup logrotate
sudo nano /etc/logrotate.d/dinasolution

/var/www/dinasolution/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    copytruncate
    su www-data www-data
}

# Setup backup script
sudo nano /usr/local/bin/backup-dinasolution.sh

#!/bin/bash
BACKUP_DIR="/backup/dinasolution"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u root -p DinasSolution > $BACKUP_DIR/db_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/dinasolution --exclude=vendor --exclude=node_modules

# Clean old backups (keep 7 days)
find $BACKUP_DIR -type f -mtime +7 -delete

# Make executable
sudo chmod +x /usr/local/bin/backup-dinasolution.sh

# Add to crontab (daily at 2 AM)
sudo crontab -e
# 0 2 * * * /usr/local/bin/backup-dinasolution.sh
```

### 🐳 Docker Deployment

#### Dockerfile
```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

#### Docker Compose
```yaml
version: '3.8'

services:
  app:
    build: .
    volumes:
      - .:/var/www
      - ./storage:/var/www/storage
    depends_on:
      - database
      - redis

  web:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - .:/var/www
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
      - ./ssl:/etc/nginx/ssl
    depends_on:
      - app

  database:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: dinasolution
      MYSQL_USER: dinasolution
      MYSQL_PASSWORD: dinasolution
    volumes:
      - database_data:/var/lib/mysql

  redis:
    image: redis:alpine

  queue:
    build: .
    command: php artisan queue:work --daemon
    volumes:
      - .:/var/www
      - ./storage:/var/www/storage
    depends_on:
      - database
      - redis

volumes:
  database_data:
```

---

## 🤝 Kontribusi

### 📝 Contributing Guidelines

#### 1. Fork & Clone
```bash
# Fork repository di GitHub
# Clone fork Anda
git clone https://github.com/your-username/dinasolution.git
cd dinasolution

# Add upstream remote
git remote add upstream https://github.com/original/dinasolution.git
```

#### 2. Create Feature Branch
```bash
# Sync dengan upstream
git fetch upstream
git checkout main
git merge upstream/main

# Create feature branch
git checkout -b feature/your-feature-name

# Make changes dan commit
git add .
git commit -m "Add: your feature description"
```

#### 3. Code Standards

#### PHP Code Standards (PSR-12)
```bash
# Install PHP CS Fixer
composer require --dev friendsofphp/php-cs-fixer

# Fix code style
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php

# Or use Laravel Pint (built-in)
./vendor/bin/pint
```

#### JavaScript Code Standards
```bash
# Install ESLint (if using npm)
npm install --save-dev eslint

# Run linter
npm run lint

# Fix automatically
npm run lint:fix
```

#### 4. Commit Message Convention
```
type(scope): subject

Body (optional)

Footer (optional)

Types:
- feat: New feature
- fix: Bug fix
- docs: Documentation changes
- style: Code style changes
- refactor: Code refactoring
- test: Adding tests
- chore: Build process or auxiliary tool changes

Examples:
feat(exam): add timer functionality for exams
fix(payment): resolve midtrans webhook issue
docs(api): update API documentation for payment endpoints
```

#### 5. Pull Request Process

##### PR Template
```markdown
## Description
Brief description of changes made

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update

## Testing
- [ ] Unit tests pass
- [ ] Integration tests pass
- [ ] Manual testing completed
- [ ] Performance testing (if applicable)

## Screenshots (if applicable)
Add screenshots for UI changes

## Checklist
- [ ] My code follows the style guidelines of this project
- [ ] I have performed a self-review of my own code
- [ ] I have commented my code, particularly in hard-to-understand areas
- [ ] I have made corresponding changes to the documentation
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix is effective or that my feature works
- [ ] New and existing unit tests pass locally with my changes
```

##### Review Process
1. **Automated Checks**: CI/CD pipeline runs automatically
2. **Code Review**: At least 2 approvals required
3. **Testing**: All tests must pass
4. **Documentation**: Update docs if needed
5. **Merge**: Squash and merge to main

### 🔧 Development Setup

#### Local Development Environment
```bash
# Clone repository
git clone https://github.com/your-username/dinasolution.git
cd dinasolution

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (SQLite for development)
touch database/database.sqlite

# Run migrations
php artisan migrate --seed

# Start development server
php artisan serve
```

#### Docker Development
```bash
# Using Laravel Sail
./vendor/bin/sail up -d

# Or using docker-compose
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate --seed

# Access application
# http://localhost
```

### 📋 Issue Reporting

#### Bug Report Template
```markdown
**Bug Description**
Clear and concise description of the bug

**Steps to Reproduce**
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected Behavior**
What you expected to happen

**Screenshots**
If applicable, add screenshots

**Environment**
- OS: [e.g. Ubuntu 20.04]
- PHP Version: [e.g. 8.1.5]
- Laravel Version: [e.g. 10.0]
- Browser: [e.g. Chrome 91.0]

**Additional Context**
Add any other context about the problem here
```

#### Feature Request Template
```markdown
**Is your feature request related to a problem?**
A clear and concise description of what the problem is

**Describe the solution you'd like**
A clear and concise description of what you want to happen

**Describe alternatives you've considered**
A clear and concise description of any alternative solutions

**Additional context**
Add any other context or screenshots about the feature request here
```

---

## 🔧 Troubleshooting

### ❌ Common Issues & Solutions

#### 1. Database Connection Issues
```bash
# Problem: "SQLSTATE[HY000] [2002] Connection refused"
# Solution:
# 1. Check if MySQL is running
sudo systemctl status mysql
sudo systemctl start mysql

# 2. Check database credentials in .env
# 3. Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

#### 2. Storage Link Issues
```bash
# Problem: Images not showing, 404 errors for uploaded files
# Solution:
rm -rf public/storage
php artisan storage:link

# Alternative: Manual symlink creation
ln -s /path/to/project/storage/app/public /path/to/project/public/storage
```

#### 3. Permission Denied Errors
```bash
# Problem: "Permission denied" on storage or cache
# Solution:
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/

# For shared hosting:
chmod 755 storage/
chmod 755 bootstrap/cache/
```

#### 4. Class Not Found Errors
```bash
# Problem: "Class not found" after composer update
# Solution:
composer dump-autoload
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 5. Payment Integration Issues
```bash
# Problem: Midtrans payment not working
# Solution:
# 1. Check Midtrans credentials in .env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key

# 2. Check sandbox/production mode
MIDTRANS_IS_PRODUCTION=false

# 3. Check webhook URL configuration
# 4. Check Midtrans dashboard for transaction logs
```

#### 6. Email Not Sending
```bash
# Problem: Email notifications not working
# Solution:
# 1. Check SMTP configuration in .env
# 2. Test email sending
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# 3. Check queue worker
php artisan queue:work

# 4. Check email logs
tail -f storage/logs/laravel.log
```

#### 7. File Upload Issues
```bash
# Problem: File uploads failing
# Solution:
# 1. Check PHP upload limits
php -i | grep upload

# 2. Increase limits in php.ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300

# 3. Check storage permissions
chmod -R 775 storage/app/public
```

#### 8. Queue Jobs Not Processing
```bash
# Problem: Background jobs not running
# Solution:
# 1. Start queue worker
php artisan queue:work --daemon

# 2. Check failed jobs
php artisan queue:failed

# 3. Retry failed jobs
php artisan queue:retry all

# 4. Check queue configuration
QUEUE_CONNECTION=database
```

#### 9. Session Issues
```bash
# Problem: User getting logged out frequently
# Solution:
# 1. Check session configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# 2. Clear session table
php artisan tinker
>>> DB::table('sessions')->truncate();

# 3. Check session storage permissions
```

#### 10. Performance Issues
```bash
# Problem: Slow page load times
# Solution:
# 1. Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Optimize database
php artisan db:show --counts

# 3. Check for N+1 queries
# Enable query logging in development

# 4. Use Redis for caching
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 📊 Debugging Tools

#### Laravel Debugbar
```bash
# Install debugbar (development only)
composer require --dev barryvdh/laravel-debugbar

# Access via browser
# Shows queries, memory usage, performance metrics
```

#### Telescope (Laravel 8+)
```bash
# Install Telescope
php artisan telescope:install
php artisan migrate

# Access via browser: /telescope
# For development environment only
```

#### Query Logging
```php
// Enable query logging temporarily
DB::enableQueryLog();
// ... your code ...
$queries = DB::getQueryLog();
dd($queries);
```

### 🔍 Log Analysis

#### Application Logs
```bash
# View real-time logs
tail -f storage/logs/laravel.log

# Search for errors
grep -i error storage/logs/laravel.log

# Search for specific messages
grep "Payment" storage/logs/laravel.log
```

#### Web Server Logs
```bash
# Nginx access log
tail -f /var/log/nginx/access.log

# Nginx error log
tail -f /var/log/nginx/error.log

# Apache access log
tail -f /var/log/apache2/access.log

# Apache error log
tail -f /var/log/apache2/error.log
```

#### Database Logs
```bash
# MySQL error log
sudo tail -f /var/log/mysql/error.log

# MySQL slow query log
sudo tail -f /var/log/mysql/mysql-slow.log
```

---

## 🔒 Security

### 🛡️ Security Best Practices

#### 1. Authentication & Authorization
```php
// Strong password validation
'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',

// Rate limiting for login
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // 5 attempts per minute

// Two-factor authentication (recommendation)
use Laravel\Fortify\Features::twoFactorAuthentication();

// CSRF protection (Laravel default)
@csrf
```

#### 2. Input Validation & Sanitization
```php
// Form Request Validation
class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'regex:/^[0-9+\-\s]+$/',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
        ];
    }
}

// XSS Protection
{{ old('description') }} // Laravel auto-escapes
{!! old('description') !!} // Only use when needed

// File upload validation
public function store(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
    ]);
}
```

#### 3. SQL Injection Prevention
```php
// Use Eloquent ORM (automatically prevents SQL injection)
$user = User::where('email', $request->email)->first();

// Or use parameter binding
$users = DB::select('SELECT * FROM users WHERE role = ?', [$role]);

// Avoid raw queries when possible
// BAD: DB::select("SELECT * FROM users WHERE email = '$email'")
// GOOD: User::where('email', $email)->get()
```

#### 4. File Security
```php
// Validate file types and sizes
public function uploadFile(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
    ]);

    // Store with unique names
    $filename = time() . '_' . $request->file->getClientOriginalName();
    $path = $request->file('file')->storeAs('uploads', $filename, 'public');

    // Don't trust client-side file names
    // Store original name separately if needed
}
```

#### 5. Environment Security
```bash
# .env file should NEVER be committed
echo ".env" >> .gitignore

# Generate strong APP_KEY
php artisan key:generate

# Use strong database passwords
DB_PASSWORD=your_very_secure_password_here

# Secure session configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# HTTPS in production
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
```

#### 6. Middleware Security
```php
// Security Headers Middleware
class SecurityHeadersMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Content Type Sniffing Protection
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Frame Options
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Content Security Policy
        $response->headers->set('Content-Security-Policy', "default-src 'self'");
        
        return $response;
    }
}
```

#### 7. API Security
```php
// API Authentication with Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/exams/{id}/submit', [ExamController::class, 'submit']);
});

// Rate limiting for API
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/exams/{id}/submit', [ExamController::class, 'submit']);
});

// CORS configuration (config/cors.php)
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['https://yourdomain.com'],
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,
```

### 🔐 User Data Protection

#### Data Encryption
```php
// Encrypt sensitive data
use Illuminate\Support\Facades\Crypt;

class User extends Model
{
    protected $fillable = [
        'name', 'email', 'encrypted_phone', 'encrypted_address'
    ];

    // Automatically encrypt/decrypt
    public function setPhoneAttribute($value)
    {
        $this->attributes['encrypted_phone'] = Crypt::encryptString($value);
    }

    public function getPhoneAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
```

#### Personal Data Handling
```php
// GDPR Compliance
class User extends Authenticatable
{
    // Anonymize user data
    public function anonymize()
    {
        $this->update([
            'name' => 'Anonymous User',
            'email' => 'anonymous_' . $this->id . '@deleted.local',
            'phone' => null,
            'address' => null,
            'avatar' => null,
        ]);
    }

    // Export user data (GDPR right to data portability)
    public function exportData()
    {
        return [
            'profile' => $this->only(['name', 'email', 'phone', 'created_at']),
            'purchases' => $this->pembelian()->get(),
            'exam_results' => $this->ujianUser()->get(),
        ];
    }
}
```

#### Session Security
```php
// Secure session configuration
// config/session.php
'driver' => env('SESSION_DRIVER', 'database'),
'lifetime' => env('SESSION_LIFETIME', 120),
'expire_on_close' => false,
'encrypt' => false,
'files' => storage_path('framework/sessions'),
'connection' => env('SESSION_CONNECTION', null),
'table' => 'sessions',
'store' => env('SESSION_STORE', null),
'lottery' => [2, 100],
'cookie' => env(
    'SESSION_COOKIE',
    'dinasolution_session'
),
'path' => '/',
'domain' => env('SESSION_DOMAIN', null),
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'lax',
```

### 🔍 Security Monitoring

#### Failed Login Attempts
```php
// Track failed login attempts
class LoginAttempt
{
    public static function record($email, $success = false)
    {
        if (!$success) {
            $attempts = LoginAttempt::where('email', $email)
                ->where('created_at', '>=', now()->subMinutes(15))
                ->count();
            
            if ($attempts >= 5) {
                // Lock account or trigger alert
                event(new TooManyFailedAttempts($email));
            }
        }
        
        LoginAttempt::create([
            'email' => $email,
            'ip_address' => request()->ip(),
            'success' => $success,
            'user_agent' => request()->userAgent(),
        ]);
    }
}
```

#### Suspicious Activity Detection
```php
// Monitor for suspicious activities
class SecurityMonitor
{
    public static function logActivity($user, $action, $details = [])
    {
        $activity = [
            'user_id' => $user->id,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => json_encode($details),
            'timestamp' => now(),
        ];

        // Check for suspicious patterns
        if (self::isSuspicious($activity)) {
            event(new SuspiciousActivityDetected($activity));
        }

        SecurityLog::create($activity);
    }

    private static function isSuspicious($activity)
    {
        // Check for rapid-fire requests
        $recentRequests = SecurityLog::where('user_id', $activity['user_id'])
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        if ($recentRequests > 100) {
            return true;
        }

        // Check for multiple IP addresses
        $uniqueIPs = SecurityLog::where('user_id', $activity['user_id'])
            ->where('created_at', '>=', now()->subMinutes(60))
            ->distinct('ip_address')
            ->count();

        if ($uniqueIPs > 3) {
            return true;
        }

        return false;
    }
}
```

---

## ⚡ Performance

### 🚀 Performance Optimization

#### 1. Database Optimization
```php
// Use indexes for better query performance
// database/migrations/add_indexes.php
Schema::table('ujian_user', function (Blueprint $table) {
    $table->index(['user_id', 'ujian_id']);
    $table->index(['status']);
    $table->index(['created_at']);
});

Schema::table('materials', function (Blueprint $table) {
    $table->index(['batch_id', 'tutor_id']);
    $table->index(['chapter_number', 'material_order']);
    $table->index(['is_public', 'is_featured']);
});

// Use eager loading to prevent N+1 queries
$users = User::with(['pembelian.paketUjian', 'ujianUser.ujian'])
    ->where('role', 'user')
    ->paginate(15);

// Use query scopes for cleaner queries
class PaketUjian extends Model
{
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('waktu_mulai', '<=', now())
                    ->where('waktu_akhir', '>=', now());
    }
}

// Usage
$paketAktif = PaketUjian::active()->get();
```

#### 2. Caching Strategy
```php
// Cache expensive queries
public function getDashboardStats()
{
    return Cache::remember('dashboard_stats', 3600, function () {
        return [
            'total_users' => User::count(),
            'active_purchases' => Pembelian::where('status', 'sukses')->count(),
            'today_exams' => Ujian::whereDate('waktu_mulai', today())->count(),
        ];
    });
}

// Cache user-specific data
public function getUserMaterials($userId)
{
    return Cache::remember("user_materials_{$userId}", 1800, function () use ($userId) {
        return Material::whereHas('batch.pembelian', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'sukses');
        })->get();
    });
}

// Cache configuration
// .env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

// config/cache.php
'stores' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
    ],
],
```

#### 3. Queue Jobs for Heavy Tasks
```php
// Process heavy tasks in background
class ProcessExamResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ujianUserId;

    public function __construct($ujianUserId)
    {
        $this->ujianUserId = $ujianUserId;
    }

    public function handle()
    {
        $ujianUser = UjianUser::find($this->ujianUserId);
        
        // Calculate scores, rankings, statistics
        $this->calculateScores($ujianUser);
        $this->updateRankings($ujianUser->ujian_id);
        $this->generateReport($ujianUser);
        
        // Send notification
        event(new ExamResultsReady($ujianUser));
    }
}

// Usage
ProcessExamResults::dispatch($ujianUserId);

// Schedule background tasks
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        // Clean up old cache
        Cache::flush();
        
        // Generate daily reports
        ReportGenerator::generateDailyReport();
        
        // Archive old exam data
        ExamArchiver::archiveOldExams();
    })->daily();
}
```

#### 4. Frontend Optimization
```javascript
// Lazy loading for images
<img src="placeholder.jpg" 
     data-src="actual-image.jpg" 
     class="lazy-load" 
     alt="Description">

<script>
// Intersection Observer for lazy loading
const images = document.querySelectorAll('.lazy-load');
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy-load');
            imageObserver.unobserve(img);
        }
    });
});

images.forEach(img => imageObserver.observe(img));
</script>

// Debounce search inputs
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

const searchInput = document.getElementById('search');
searchInput.addEventListener('input', debounce((e) => {
    performSearch(e.target.value);
}, 300));
```

#### 5. Asset Optimization
```bash
# Build optimized assets
npm run build

# Enable gzip compression
# .htaccess for Apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Cache static assets
# .htaccess
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
</IfModule>
```

### 📊 Performance Monitoring

#### Application Performance Monitoring
```php
// Add performance monitoring
class PerformanceMonitor
{
    public static function measure($operation, callable $callback)
    {
        $start = microtime(true);
        $memoryStart = memory_get_usage();
        
        $result = $callback();
        
        $duration = microtime(true) - $start;
        $memoryUsage = memory_get_usage() - $memoryStart;
        
        if ($duration > 2.0) { // Log if > 2 seconds
            Log::warning("Slow operation detected", [
                'operation' => $operation,
                'duration' => $duration,
                'memory_usage' => $memoryUsage,
                'peak_memory' => memory_get_peak_usage(),
            ]);
        }
        
        return $result;
    }
}

// Usage
public function getExamResults($userId)
{
    return PerformanceMonitor::measure('exam_results', function () use ($userId) {
        return UjianUser::with(['ujian', 'jawabanPeserta.soal'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    });
}
```

#### Database Query Monitoring
```php
// Log slow queries in development
// AppServiceProvider.php
public function boot()
{
    if (app()->environment('local')) {
        DB::listen(function ($query) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            
            if ($time > 100) { // Log queries > 100ms
                Log::warning("Slow query detected", [
                    'sql' => $sql,
                    'bindings' => $bindings,
                    'time' => $time . 'ms',
                ]);
            }
        });
    }
}
```

---

## 📝 Changelog

### Version 2.1.0 - Payment System Enhancement (2024-12-19)

#### ✨ New Features
- **Payment Notifications**: Complete email notification system for all payment states
- **Manual Payment Verification**: Admin panel untuk verifikasi bukti transfer
- **WhatsApp Integration**: Auto-generate WhatsApp links untuk customer support
- **Midtrans Webhook**: Automatic payment status updates via webhooks
- **Payment Analytics**: Dashboard untuk monitoring transaksi dan revenue

#### 🔧 Improvements
- **Email Templates**: New responsive HTML templates dengan branding konsisten
- **Admin Dashboard**: Enhanced statistics dan payment management interface
- **User Experience**: Better payment flow dengan progress indicators
- **Error Handling**: Improved error messages dan fallback mechanisms

#### 🐛 Bug Fixes
- Fixed "Property [status] does not exist on collection instance" error
- Resolved payment callback processing issues
- Fixed email delivery untuk certain SMTP configurations
- Corrected user role permission checking

#### 🔒 Security
- Enhanced input validation untuk payment forms
- Improved CSRF protection untuk sensitive actions
- Better sanitization of uploaded proof of payment files

### Version 2.0.0 - Integrated Admin System (2024-12-10)

#### ✨ New Features
- **Integrated Admin Dashboard**: Single interface untuk manage courses, materials, dan users
- **Dynamic Form System**: Add/remove chapters dan materials dynamically
- **Atomic Operations**: Save/Update entire course structure dalam satu transaction
- **Responsive Admin Layout**: Mobile-friendly admin interface
- **Course Duplication**: Copy entire course structures untuk reuse

#### 🔧 Improvements
- **Performance**: Optimized database queries dengan proper indexing
- **User Experience**: Streamlined admin workflow
- **Code Quality**: Refactored controllers untuk better maintainability
- **Error Handling**: Better error messages dan validation

#### 🐛 Bug Fixes
- Fixed route definition errors
- Resolved database field default value issues
- Corrected admin layout JavaScript errors
- Fixed missing admin layout template issues

### Version 1.5.0 - Exam System Enhancement (2024-11-28)

#### ✨ New Features
- **Advanced Exam Interface**: Improved UI untuk better exam experience
- **Timer System**: Visual countdown timer dengan auto-submit
- **Question Marking**: Mark questions untuk review
- **Progress Tracking**: Real-time exam progress indicator
- **Result Analytics**: Detailed score analysis dan percentile ranking

#### 🔧 Improvements
- **Performance**: Optimized exam loading dan submission
- **Accessibility**: Better keyboard navigation dan screen reader support
- **Mobile Experience**: Responsive exam interface
- **Security**: Enhanced exam integrity measures

### Version 1.0.0 - Initial Release (2024-10-14)

#### ✨ Core Features
- **Multi-role Authentication**: Admin, Tutor, User roles
- **Course Management**: Package-based learning system
- **Exam System**: Computer Assisted Test (CAT) simulation
- **Payment Integration**: Midtrans payment gateway
- **Material System**: Chapter-based learning materials
- **Live Classes**: Online class scheduling system
- **Email Notifications**: Basic email system
- **Responsive Design**: Mobile-first approach

#### 📚 Documentation
- Complete API documentation
- Deployment guide
- User manual
- Admin guide

---

## 📜 Lisensi

### MIT License

Copyright (c) 2024 DinasSolution

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

### Third-Party Licenses

#### Laravel Framework
- **License**: MIT License
- **Copyright**: Taylor Otwell
- **Website**: https://laravel.com

#### Bootstrap
- **License**: MIT License
- **Copyright**: Twitter, Inc.
- **Website**: https://getbootstrap.com

#### AdminLTE
- **License**: MIT License
- **Copyright**: Colorlib
- **Website**: https://adminlte.io

#### Midtrans PHP SDK
- **License**: MIT License
- **Copyright**: Midtrans
- **Website**: https://midtrans.com

#### Spatie Laravel Permission
- **License**: MIT License
- **Copyright**: Spatie BVBA
- **Website**: https://spatie.be

---

## 👥 Tim Pengembang

### 🏆 Core Team
- **Lead Developer**: [Your Name](mailto:your.email@domain.com)
- **UI/UX Designer**: [Designer Name](mailto:designer@domain.com)
- **Backend Developer**: [Backend Dev Name](mailto:backend@domain.com)
- **QA Engineer**: [QA Name](mailto:qa@domain.com)

### 🤝 Contributors
- Thanks to all contributors who have helped improve this project
- Special thanks to the Laravel community for the amazing framework

### 📞 Kontak & Support

#### Technical Support
- **Email**: tech-support@dinasolution.com
- **Documentation**: https://docs.dinasolution.com
- **Issues**: https://github.com/your-repo/dinasolution/issues

#### Business Inquiries
- **Email**: info@dinasolution.com
- **WhatsApp**: +62-831-1710-6878 (Customer Service)
- **Website**: https://dinasolution.com

#### Social Media
- **Instagram**: [@dinasolution.id](https://instagram.com/dinasolution.id)
- **Facebook**: [Dinasolution](https://facebook.com/dinasolution)
- **YouTube**: [Dinasolution Channel](https://youtube.com/dinasolution)

---

## 🙏 Acknowledgments

### 🎓 Special Thanks
- **Laravel Team**: For the amazing framework
- **STIS Community**: For feedback dan testing
- **Beta Users**: For valuable feedback dan suggestions
- **Open Source Community**: For the libraries dan tools used

### 📚 Resources Used
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Best Practices](https://laravel.com/docs/master/contributing)
- [PHP-FIG Standards](https://www.php-fig.org)
- [Security Guidelines](https://owasp.org)
- [Performance Optimization](https://laravel.com/docs/master/performance)

---

**Last Updated**: December 19, 2024  
**Version**: 2.1.0  
**Maintained by**: DinasSolution Development Team  
**Status**: ✅ Active Development

---

> **"Empowering Indonesian civil service aspirants through technology and education"** 🎯

*Built with ❤️ using Laravel for the success of Indonesian students*
