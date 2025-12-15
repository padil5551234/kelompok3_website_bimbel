# 🚀 Quick Setup Guide: Chapter-Based Materials

## ⚡ 5-Minute Setup

### Step 1: Run the Seeder
```bash
# Di terminal, jalankan:
php artisan db:seed --class=ChapterBasedMaterialsSeeder
```

### Step 2: Test the System
```
1. Buka browser
2. Login sebagai user regular
3. Akses: /materials?view=chapters
4. Lihat hasilnya! 🎉
```

### Step 3: Add Route (if not working)
Jika route belum work, tambahkan ini ke `routes/web.php`:

```php
// Tambahkan setelah line 547 (setelah download route):
Route::get('/chapters', [App\Http\Controllers\UserMaterialController::class, 'chapters'])
    ->name('chapters');
```

---

## 📚 Manual Material Addition

### Via Admin Panel:
1. Login ke admin: `/admin`
2. Materials → Add New
3. **PENTING**: Isi field ini:
   - **Chapter Number**: `1` (untuk Bab 1)
   - **Chapter Title**: `Bab 1: Judul Chapter`
   - **Material Order**: `1`, `2`, `3`, dst.

### Via Database:
```sql
INSERT INTO materials (
    title, chapter_number, chapter_title, material_order, 
    type, mapel, batch_id, tutor_id, is_public, is_completable
) VALUES (
    'Judul Materi', 
    1, 
    'Bab 1: Judul Chapter', 
    1, 
    'youtube', 
    'Matematika', 
    'batch-uuid', 
    'tutor-uuid', 
    true, 
    true
);
```

---

## ✅ Testing Checklist

- [ ] Materials muncul di `/materials?view=chapters`
- [ ] Chapter grouping bekerja
- [ ] Progress bars tampil
- [ ] Material order benar
- [ ] Type badges (YouTube, PDF, Link) muncul
- [ ] Responsive di mobile

---

## 🎯 Example Output

Setelah setup, user akan melihat:

```
📚 BAB 1: KONSEP DASAR MATEMATIKA (3 materi)
   🎥 Pengenalan Matematika dan Konsep Dasar
   📄 Materi Konsep Dasar - PDF  
   🔗 Referensi Konsep Dasar Matematika

📚 BAB 2: BILANGAN DAN OPERASI (3 materi)
   🎥 Bilangan Bulat dan Operasinya
   📄 Soal Latihan Bilangan Bulat
   📹 Tips Menghitung Cepat

📚 BAB 3: BANGUN DATAR (3 materi)
   🎥 Pengenalan Bangun Datar
   📄 Rumus Bangun Datar
   🔗 Simulator Bangun Datar Interaktif
```

---

## 🆘 Troubleshooting

**Problem**: Chapter view tidak muncul
**Solution**: 
```bash
php artisan route:clear
php artisan config:clear
```

**Problem**: Materials tidak ter-group
**Solution**: Pastikan semua material punya `chapter_number` yang sama

**Problem**: Progress tidak muncul
**Solution**: Pastikan `is_completable = true`

---

## 🎉 Success!

Jika semua ✅, berarti sistem chapter Anda sudah siap digunakan!

**Next Steps:**
- Customize chapter titles di admin
- Add more chapters dan materials
- Upload actual files (PDF, video)
- Test dengan user account
