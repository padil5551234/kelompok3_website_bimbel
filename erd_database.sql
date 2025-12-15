-- ERD Database SQL Script
-- Generated from Laravel Models

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Users table
CREATE TABLE users (
    id VARCHAR(36) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    google_id VARCHAR(255),
    email_verified_at TIMESTAMP NULL,
    profile_photo_path VARCHAR(2048),
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Users Detail table
CREATE TABLE users_detail (
    id VARCHAR(36) PRIMARY KEY,
    no_hp VARCHAR(20),
    provinsi VARCHAR(100),
    kabupaten VARCHAR(100),
    kecamatan VARCHAR(100),
    asal_sekolah VARCHAR(255),
    sumber_informasi JSON,
    prodi VARCHAR(100),
    penempatan VARCHAR(255),
    instagram VARCHAR(255),
    nama_kelompok VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Paket Ujian table
CREATE TABLE paket_ujian (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2),
    is_featured BOOLEAN DEFAULT FALSE,
    waktu_mulai DATETIME,
    waktu_akhir DATETIME,
    whatsapp_group_link VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Ujian table
CREATE TABLE ujian (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    peraturan TEXT,
    jenis_ujian VARCHAR(100),
    lama_pengerjaan INT,
    waktu_mulai DATETIME,
    waktu_akhir DATETIME,
    waktu_pengumuman DATETIME,
    isPublished BOOLEAN DEFAULT FALSE,
    tipe_ujian VARCHAR(50),
    tampil_kunci BOOLEAN DEFAULT FALSE,
    tampil_nilai BOOLEAN DEFAULT FALSE,
    tampil_poin BOOLEAN DEFAULT FALSE,
    random BOOLEAN DEFAULT FALSE,
    random_pilihan BOOLEAN DEFAULT FALSE,
    jumlah_soal INT,
    allow_pembahasan_during_test BOOLEAN DEFAULT FALSE,
    pembahasan_access_limit INT,
    pembahasan_access_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pivot table for Paket Ujian and Ujian (many-to-many)
CREATE TABLE paket_ujian_ujian (
    paket_ujian_id VARCHAR(36),
    ujian_id VARCHAR(36),
    PRIMARY KEY (paket_ujian_id, ujian_id),
    FOREIGN KEY (paket_ujian_id) REFERENCES paket_ujian(id) ON DELETE CASCADE,
    FOREIGN KEY (ujian_id) REFERENCES ujian(id) ON DELETE CASCADE
);

-- Soal table
CREATE TABLE soal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ujian_id VARCHAR(36) NOT NULL,
    soal TEXT NOT NULL,
    kunci_jawaban VARCHAR(10),
    poin_benar DECIMAL(5,2) DEFAULT 0,
    poin_salah DECIMAL(5,2) DEFAULT 0,
    poin_kosong DECIMAL(5,2) DEFAULT 0,
    pembahasan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ujian_id) REFERENCES ujian(id) ON DELETE CASCADE
);

-- Jawaban table
CREATE TABLE jawaban (
    id INT AUTO_INCREMENT PRIMARY KEY,
    soal_id INT NOT NULL,
    jawaban TEXT NOT NULL,
    point DECIMAL(5,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (soal_id) REFERENCES soal(id) ON DELETE CASCADE
);

-- Voucher table
CREATE TABLE voucher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(50) UNIQUE NOT NULL,
    diskon DECIMAL(10,2),
    kuota INT,
    paket_ujian_id VARCHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (paket_ujian_id) REFERENCES paket_ujian(id) ON DELETE SET NULL
);

-- Pembelian table
CREATE TABLE pembelian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paket_id VARCHAR(36) NOT NULL,
    user_id VARCHAR(36) NOT NULL,
    kode_pembelian VARCHAR(100) UNIQUE,
    batas_pembayaran DATETIME,
    nama_kelompok VARCHAR(255),
    bukti_transfer VARCHAR(500),
    catatan_pembayaran TEXT,
    status_verifikasi ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    catatan_admin TEXT,
    verified_at TIMESTAMP NULL,
    verified_by VARCHAR(36),
    whatsapp_admin VARCHAR(255),
    id_voucher INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (paket_id) REFERENCES paket_ujian(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (id_voucher) REFERENCES voucher(id) ON DELETE SET NULL
);

-- Ujian User table
CREATE TABLE ujian_user (
    id VARCHAR(36) PRIMARY KEY,
    ujian_id VARCHAR(36) NOT NULL,
    user_id VARCHAR(36) NOT NULL,
    status VARCHAR(50),
    jml_benar INT DEFAULT 0,
    jml_salah INT DEFAULT 0,
    jml_kosong INT DEFAULT 0,
    nilai DECIMAL(5,2),
    nilai_twk DECIMAL(5,2),
    nilai_tiu DECIMAL(5,2),
    nilai_tkp DECIMAL(5,2),
    waktu_mulai DATETIME,
    waktu_akhir DATETIME,
    is_first BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ujian_id) REFERENCES ujian(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Jawaban Peserta table
CREATE TABLE jawaban_peserta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ujian_user_id VARCHAR(36) NOT NULL,
    soal_id INT NOT NULL,
    jawaban_id INT,
    ragu_ragu BOOLEAN DEFAULT FALSE,
    poin DECIMAL(5,2) DEFAULT 0,
    pembelian_id INT,
    accessed_pembahasan_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ujian_user_id) REFERENCES ujian_user(id) ON DELETE CASCADE,
    FOREIGN KEY (soal_id) REFERENCES soal(id) ON DELETE CASCADE,
    FOREIGN KEY (jawaban_id) REFERENCES jawaban(id) ON DELETE SET NULL,
    FOREIGN KEY (pembelian_id) REFERENCES pembelian(id) ON DELETE SET NULL
);

-- Materials table
CREATE TABLE materials (
    id VARCHAR(36) PRIMARY KEY,
    batch_id VARCHAR(36),
    title VARCHAR(255) NOT NULL,
    mapel VARCHAR(100),
    description TEXT,
    tutor_id VARCHAR(36),
    type ENUM('video', 'document', 'link', 'youtube') DEFAULT 'document',
    file_path VARCHAR(500),
    youtube_url VARCHAR(500),
    external_link VARCHAR(500),
    thumbnail_path VARCHAR(500),
    file_size BIGINT,
    file_type VARCHAR(50),
    views_count INT DEFAULT 0,
    downloads_count INT DEFAULT 0,
    is_public BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    tags JSON,
    content TEXT,
    duration_seconds INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES paket_ujian(id) ON DELETE SET NULL,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Live Classes table
CREATE TABLE live_classes (
    id VARCHAR(36) PRIMARY KEY,
    batch_id VARCHAR(36),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    tutor_id VARCHAR(36),
    meeting_link VARCHAR(500),
    meeting_password VARCHAR(100),
    platform ENUM('zoom', 'google_meet', 'teams', 'other') DEFAULT 'zoom',
    scheduled_at DATETIME,
    duration_minutes INT,
    max_participants INT,
    status ENUM('scheduled', 'ongoing', 'completed', 'cancelled') DEFAULT 'scheduled',
    materials JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES paket_ujian(id) ON DELETE SET NULL,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Bank Soal table
CREATE TABLE bank_soal (
    id VARCHAR(36) PRIMARY KEY,
    batch_id VARCHAR(36),
    tentor_id VARCHAR(36),
    nama_banksoal VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    mapel VARCHAR(100),
    file_banksoal VARCHAR(500),
    tanggal_upload DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES paket_ujian(id) ON DELETE SET NULL,
    FOREIGN KEY (tentor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Sessions table (for user sessions)
CREATE TABLE sessions (
    id VARCHAR(36) PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT,
    last_activity INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Learning Progress table
CREATE TABLE learning_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    paket_id VARCHAR(36),
    material_id VARCHAR(36),
    ujian_id VARCHAR(36),
    activity_type ENUM('material', 'tryout') NOT NULL,
    duration_seconds INT DEFAULT 0,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (paket_id) REFERENCES paket_ujian(id) ON DELETE SET NULL,
    FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE SET NULL,
    FOREIGN KEY (ujian_id) REFERENCES ujian(id) ON DELETE SET NULL
);

-- Study Statistics table
CREATE TABLE study_statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    total_study_time INT DEFAULT 0,
    total_materials_viewed INT DEFAULT 0,
    total_tryouts_taken INT DEFAULT 0,
    average_score DECIMAL(5,2),
    last_study_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Articles table
CREATE TABLE articles (
    id VARCHAR(36) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    excerpt TEXT,
    content TEXT,
    featured_image VARCHAR(500),
    category VARCHAR(100),
    author_id VARCHAR(36),
    status VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    views_count INT DEFAULT 0,
    tags JSON,
    meta_keywords JSON,
    meta_description TEXT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- FAQ table
CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id VARCHAR(36),
    question TEXT NOT NULL,
    answer TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Pengumuman table
CREATE TABLE pengumuman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id VARCHAR(36),
    paket_id VARCHAR(36),
    title VARCHAR(255) NOT NULL,
    content TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (paket_id) REFERENCES paket_ujian(id) ON DELETE SET NULL
);

-- Formasi table
CREATE TABLE formasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Prodi table
CREATE TABLE prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Wilayah table
CREATE TABLE wilayah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Indexes for performance
CREATE INDEX idx_pembelian_user_id ON pembelian(user_id);
CREATE INDEX idx_pembelian_paket_id ON pembelian(paket_id);
CREATE INDEX idx_pembelian_id_voucher ON pembelian(id_voucher);
CREATE INDEX idx_soal_ujian_id ON soal(ujian_id);
CREATE INDEX idx_jawaban_soal_id ON jawaban(soal_id);
CREATE INDEX idx_jawaban_peserta_ujian_user_id ON jawaban_peserta(ujian_user_id);
CREATE INDEX idx_ujian_user_user_id ON ujian_user(user_id);
CREATE INDEX idx_ujian_user_ujian_id ON ujian_user(ujian_id);
CREATE INDEX idx_materials_batch_id ON materials(batch_id);
CREATE INDEX idx_live_classes_batch_id ON live_classes(batch_id);
CREATE INDEX idx_bank_soal_batch_id ON bank_soal(batch_id);
CREATE INDEX idx_learning_progress_user_id ON learning_progress(user_id);
CREATE INDEX idx_study_statistics_user_id ON study_statistics(user_id);

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;