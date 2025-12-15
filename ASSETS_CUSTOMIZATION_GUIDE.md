# 🎨 Panduan Kustomisasi Assets

Dokumen ini menjelaskan cara mengubah logo, gambar, warna, dan assets lainnya tanpa perlu mengubah kode.

---

## 📁 Struktur Assets

```
public/assets/
├── config/
│   └── branding.json          # File konfigurasi utama
├── images/
│   ├── logo/                  # Semua variasi logo
│   ├── backgrounds/           # Background images
│   ├── illustrations/         # SVG illustrations
│   ├── avatars/              # Default avatars
│   └── banners/              # Hero banners
├── css/
│   └── custom/               # CSS kustom
└── js/
    └── custom/               # JavaScript kustom
```

---

## 🎯 Konfigurasi Cepat: branding.json

File [`public/assets/config/branding.json`](public/assets/config/branding.json) adalah pusat konfigurasi untuk semua assets visual.

### Contoh File Lengkap:

```json
{
  "app": {
    "name": "Try-Out STAN",
    "short_name": "TOSTAN",
    "description": "Platform Try-Out Online Terbaik",
    "url": "https://tryout.example.com",
    "support_email": "support@tryout.example.com",
    "support_phone": "+62 812-3456-7890"
  },
  "branding": {
    "logo": {
      "main": "/assets/images/logo/logo-main.png",
      "light": "/assets/images/logo/logo-light.png",
      "dark": "/assets/images/logo/logo-dark.png",
      "icon": "/assets/images/logo/logo-icon.png",
      "text": "/assets/images/logo/logo-text.png"
    },
    "favicon": "/assets/images/logo/logo-icon.png"
  },
  "theme": {
    "colors": {
      "primary": "#17c1e8",
      "secondary": "#7928ca",
      "success": "#82d616",
      "info": "#17c1e8",
      "warning": "#f53939",
      "danger": "#ea0606",
      "light": "#e9ecef",
      "dark": "#344767"
    },
    "gradients": {
      "primary": "linear-gradient(310deg, #17c1e8 0%, #17c1e8 100%)",
      "secondary": "linear-gradient(310deg, #7928ca 0%, #ff0080 100%)",
      "success": "linear-gradient(310deg, #82d616 0%, #82d616 100%)",
      "info": "linear-gradient(310deg, #2152ff 0%, #21d4fd 100%)",
      "warning": "linear-gradient(310deg, #f53939 0%, #fbcf33 100%)",
      "danger": "linear-gradient(310deg, #ea0606 0%, #ff667c 100%)",
      "dark": "linear-gradient(310deg, #141727 0%, #3a416f 100%)"
    },
    "fonts": {
      "primary": "'Open Sans', sans-serif",
      "headings": "'Roboto', sans-serif",
      "code": "'Fira Code', monospace"
    },
    "border_radius": {
      "small": "0.25rem",
      "default": "0.5rem",
      "large": "0.75rem",
      "xl": "1rem"
    }
  },
  "backgrounds": {
    "login": "/assets/images/backgrounds/login-bg.jpg",
    "auth_pattern": "/assets/images/backgrounds/auth-pattern.svg",
    "dashboard_user": "/assets/images/banners/hero-user.jpg",
    "dashboard_tutor": "/assets/images/banners/hero-tutor.jpg",
    "dashboard_admin": "/assets/images/banners/hero-admin.jpg"
  },
  "social": {
    "facebook": "https://facebook.com/yourpage",
    "twitter": "https://twitter.com/yourhandle",
    "instagram": "https://instagram.com/yourhandle",
    "youtube": "https://youtube.com/yourchannel",
    "linkedin": "https://linkedin.com/company/yourcompany",
    "whatsapp": "https://wa.me/6281234567890"
  },
  "features": {
    "show_social_links": true,
    "show_footer_copyright": true,
    "enable_dark_mode": false,
    "enable_google_analytics": true,
    "google_analytics_id": "UA-XXXXXXXXX-X"
  }
}
```

---

## 🖼️ Mengganti Logo

### Step 1: Persiapkan File Logo

Anda membutuhkan 5 variasi logo:

| Variasi | Ukuran | Format | Kegunaan |
|---------|--------|--------|----------|
| **logo-main.png** | 500x500px | PNG transparent | Logo utama untuk halaman putih |
| **logo-light.png** | 500x500px | PNG transparent | Logo untuk background gelap |
| **logo-dark.png** | 500x500px | PNG transparent | Logo untuk background terang |
| **logo-icon.png** | 128x128px | PNG transparent | Favicon & icon aplikasi |
| **logo-text.png** | 300x100px | PNG transparent | Logo hanya teks (opsional) |

### Step 2: Upload File

1. Buka folder `public/assets/images/logo/`
2. Replace file-file yang ada dengan logo baru Anda
3. **Penting**: Gunakan nama file yang sama atau update [`branding.json`](public/assets/config/branding.json)

### Step 3: Update Konfigurasi (Jika Nama File Berbeda)

Edit [`public/assets/config/branding.json`](public/assets/config/branding.json):

```json
{
  "branding": {
    "logo": {
      "main": "/assets/images/logo/my-new-logo.png",
      "light": "/assets/images/logo/my-logo-white.png",
      "dark": "/assets/images/logo/my-logo-dark.png",
      "icon": "/assets/images/logo/my-icon.png",
      "text": "/assets/images/logo/my-logo-text.png"
    }
  }
}
```

### Step 4: Clear Cache

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Tips Logo Design:

✅ **DO:**
- Gunakan format PNG dengan transparent background
- Pertahankan aspect ratio yang konsisten
- Pastikan logo readable di ukuran kecil
- Gunakan warna yang kontras dengan background

❌ **DON'T:**
- Jangan gunakan JPEG (tidak ada transparency)
- Jangan membuat logo terlalu detail/kompleks
- Jangan gunakan ukuran file > 500KB

---

## 🎨 Mengganti Warna Tema

### Metode 1: Via branding.json (Recommended)

Edit [`public/assets/config/branding.json`](public/assets/config/branding.json):

```json
{
  "theme": {
    "colors": {
      "primary": "#FF6B6B",      // Warna utama Anda
      "secondary": "#4ECDC4",    // Warna sekunder
      "success": "#95E1D3",      // Warna success (hijau)
      "info": "#38A3A5",         // Warna info (biru)
      "warning": "#FFBE0B",      // Warna warning (kuning)
      "danger": "#F72585",       // Warna danger (merah)
      "light": "#F8F9FA",        // Background terang
      "dark": "#212529"          // Background gelap
    }
  }
}
```

### Metode 2: Via CSS Variables

Edit [`public/assets/css/custom/variables.css`](public/assets/css/custom/variables.css):

```css
:root {
  /* Primary Colors */
  --color-primary: #FF6B6B;
  --color-primary-light: #FF8E8E;
  --color-primary-dark: #E05555;
  
  /* Secondary Colors */
  --color-secondary: #4ECDC4;
  --color-secondary-light: #6FD9D0;
  --color-secondary-dark: #3BB8AF;
  
  /* Success Colors */
  --color-success: #95E1D3;
  --color-success-light: #B0E9DE;
  --color-success-dark: #7DCFC0;
  
  /* Neutral Colors */
  --color-gray-100: #F8F9FA;
  --color-gray-200: #E9ECEF;
  --color-gray-300: #DEE2E6;
  --color-gray-400: #CED4DA;
  --color-gray-500: #ADB5BD;
  --color-gray-600: #6C757D;
  --color-gray-700: #495057;
  --color-gray-800: #343A40;
  --color-gray-900: #212529;
  
  /* Text Colors */
  --text-primary: #344767;
  --text-secondary: #67748E;
  --text-muted: #ADB5BD;
  
  /* Background Colors */
  --bg-primary: #FFFFFF;
  --bg-secondary: #F8F9FA;
  --bg-dark: #344767;
  
  /* Border & Shadow */
  --border-color: #DEE2E6;
  --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}
```

### Metode 3: Per Role Customization

#### User Theme - [`public/assets/css/custom/user-theme.css`](public/assets/css/custom/user-theme.css):
```css
body.role-user {
  --theme-primary: #17c1e8;  /* Cyan/Teal untuk User */
  --theme-gradient: linear-gradient(310deg, #17c1e8 0%, #21d4fd 100%);
}

body.role-user .btn-primary {
  background: var(--theme-gradient);
}

body.role-user .sidebar .nav-link.active {
  background: var(--theme-gradient);
}
```

#### Tutor Theme - [`public/assets/css/custom/tutor-theme.css`](public/assets/css/custom/tutor-theme.css):
```css
body.role-tutor {
  --theme-primary: #82d616;  /* Green untuk Tutor */
  --theme-gradient: linear-gradient(310deg, #82d616 0%, #a8eb12 100%);
}

body.role-tutor .btn-primary {
  background: var(--theme-gradient);
}
```

#### Admin Theme - [`public/assets/css/custom/admin-theme.css`](public/assets/css/custom/admin-theme.css):
```css
body.role-admin {
  --theme-primary: #7928ca;  /* Purple untuk Admin */
  --theme-gradient: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
}

body.role-admin .btn-primary {
  background: var(--theme-gradient);
}
```

### Color Palette Generator Tools:

- **Coolors**: https://coolors.co/
- **Adobe Color**: https://color.adobe.com/
- **Material Palette**: https://www.materialpalette.com/
- **ColorHunt**: https://colorhunt.co/

---

## 🖼️ Mengganti Background Images

### Login Background

1. **Persiapkan gambar**:
   - Ukuran: 1920x1080px (Full HD) atau lebih tinggi
   - Format: JPG atau PNG
   - Ukuran file: < 500KB (optimized)

2. **Upload**:
   ```
   public/assets/images/backgrounds/login-bg.jpg
   ```

3. **Update konfigurasi**:
   ```json
   {
     "backgrounds": {
       "login": "/assets/images/backgrounds/login-bg.jpg"
     }
   }
   ```

### Dashboard Banners

Untuk masing-masing role:

```json
{
  "backgrounds": {
    "dashboard_user": "/assets/images/banners/user-hero.jpg",
    "dashboard_tutor": "/assets/images/banners/tutor-hero.jpg",
    "dashboard_admin": "/assets/images/banners/admin-hero.jpg"
  }
}
```

Spesifikasi banner:
- Ukuran: 1920x600px
- Format: JPG optimized
- Subject: Sesuai dengan tema (education, technology, etc.)

### Pattern Backgrounds (SVG)

Untuk pattern dekoratif, gunakan SVG:

```json
{
  "backgrounds": {
    "auth_pattern": "/assets/images/backgrounds/pattern.svg"
  }
}
```

**Free SVG Pattern Resources:**
- https://heropatterns.com/
- https://www.svgbackgrounds.com/
- https://bgjar.com/

---

## 🎭 Mengganti Illustrations

### Empty State Illustrations

Path: `public/assets/images/illustrations/`

Gunakan untuk:
- Halaman kosong (no data)
- Error pages (404, 500)
- Success messages
- Onboarding screens

**Recommended sources:**
- https://undraw.co/ (free, customizable)
- https://www.manypixels.co/gallery (free)
- https://storyset.com/ (free, animated)
- https://www.drawkit.io/ (free & premium)

### Cara Replace:

1. Download illustration dalam format SVG
2. Save ke `public/assets/images/illustrations/`
3. Update di view files:

```blade
<img src="{{ asset('assets/images/illustrations/empty-data.svg') }}" 
     alt="No Data" 
     class="img-fluid" 
     style="max-width: 400px;">
```

---

## 🔤 Mengganti Font

### Step 1: Pilih Font

**Google Fonts**: https://fonts.google.com/

Contoh kombinasi yang bagus:
- **Modern**: Poppins + Roboto
- **Classic**: Merriweather + Open Sans
- **Tech**: Inter + Fira Code
- **Elegant**: Playfair Display + Lato

### Step 2: Update Configuration

Edit [`branding.json`](public/assets/config/branding.json):

```json
{
  "theme": {
    "fonts": {
      "primary": "'Poppins', sans-serif",
      "headings": "'Montserrat', sans-serif",
      "code": "'Fira Code', monospace"
    }
  }
}
```

### Step 3: Load Font

Edit base layout [`resources/views/layouts/base-soft-ui.blade.php`](resources/views/layouts/base-soft-ui.blade.php):

```html
<head>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
</head>
```

### Step 4: Apply in CSS

```css
:root {
  --font-primary: 'Poppins', sans-serif;
  --font-headings: 'Montserrat', sans-serif;
}

body {
  font-family: var(--font-primary);
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-headings);
}
```

---

## 🌐 Mengganti Social Media Links

Edit [`branding.json`](public/assets/config/branding.json):

```json
{
  "social": {
    "facebook": "https://facebook.com/yourpage",
    "twitter": "https://twitter.com/yourhandle",
    "instagram": "https://instagram.com/yourhandle",
    "youtube": "https://youtube.com/yourchannel",
    "linkedin": "https://linkedin.com/company/yourcompany",
    "whatsapp": "https://wa.me/6281234567890",
    "telegram": "https://t.me/yourchannel",
    "tiktok": "https://tiktok.com/@yourhandle"
  }
}
```

Links ini akan muncul di:
- Footer halaman
- Profile pages
- Contact page
- Email signatures

---

## 📧 Customizing Email Templates

### Logo di Email

File: `resources/views/emails/template.blade.php`

```blade
<img src="{{ asset('assets/images/logo/logo-main.png') }}" 
     alt="{{ config('app.name') }}" 
     style="height: 50px;">
```

### Email Colors

```blade
<style>
  .email-header {
    background: {{ config('branding.theme.colors.primary', '#17c1e8') }};
  }
  
  .email-button {
    background: {{ config('branding.theme.colors.primary', '#17c1e8') }};
    color: white;
  }
</style>
```

---

## 🎚️ Advanced Customization

### Custom CSS untuk Specific Pages

Buat file CSS baru di `public/assets/css/custom/pages/`:

```css
/* public/assets/css/custom/pages/exam-page.css */
.exam-container {
  background: #f8f9fa;
  border-radius: 1rem;
  padding: 2rem;
}

.exam-timer {
  position: fixed;
  top: 20px;
  right: 20px;
  background: white;
  padding: 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
```

Load di view:

```blade
@push('styles')
<link href="{{ asset('assets/css/custom/pages/exam-page.css') }}" rel="stylesheet">
@endpush
```

### Custom JavaScript Behavior

Buat file JS di `public/assets/js/custom/`:

```javascript
// public/assets/js/custom/exam-timer.js
class ExamTimer {
  constructor(duration) {
    this.duration = duration;
    this.remaining = duration;
    this.interval = null;
  }
  
  start() {
    this.interval = setInterval(() => {
      this.remaining--;
      this.updateDisplay();
      
      if (this.remaining <= 0) {
        this.stop();
        this.onTimeout();
      }
    }, 1000);
  }
  
  stop() {
    if (this.interval) {
      clearInterval(this.interval);
    }
  }
  
  updateDisplay() {
    const minutes = Math.floor(this.remaining / 60);
    const seconds = this.remaining % 60;
    document.getElementById('timer-display').textContent = 
      `${minutes}:${seconds.toString().padStart(2, '0')}`;
  }
  
  onTimeout() {
    alert('Waktu habis!');
    document.getElementById('exam-form').submit();
  }
}
```

---

## 🔄 Cache Clearing

Setelah mengubah assets, selalu clear cache:

```bash
# Clear all cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Or use optimize command
php artisan optimize:clear

# Regenerate optimized files
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Checklist Kustomisasi

### Logo & Branding
- [ ] Logo utama (logo-main.png)
- [ ] Logo untuk dark background (logo-light.png)
- [ ] Logo untuk light background (logo-dark.png)
- [ ] Icon/Favicon (logo-icon.png)
- [ ] Logo text only (logo-text.png)
- [ ] Update branding.json

### Colors
- [ ] Primary color
- [ ] Secondary color
- [ ] Success color
- [ ] Warning color
- [ ] Danger color
- [ ] Update CSS variables

### Images
- [ ] Login background
- [ ] User dashboard banner
- [ ] Tutor dashboard banner
- [ ] Admin dashboard banner
- [ ] Pattern backgrounds
- [ ] Illustrations (empty state, errors, etc.)

### Typography
- [ ] Primary font
- [ ] Heading font
- [ ] Code font
- [ ] Load Google Fonts

### Links & Info
- [ ] App name & description
- [ ] Social media links
- [ ] Contact information
- [ ] Support email & phone

### Testing
- [ ] Clear all caches
- [ ] Test on desktop browser
- [ ] Test on mobile browser
- [ ] Test on different roles
- [ ] Verify all images load correctly
- [ ] Check responsive design

---

## 🆘 Troubleshooting

### Logo Tidak Muncul

**Problem**: Logo tidak terlihat setelah diganti

**Solutions**:
1. Check file path di branding.json
2. Clear browser cache (Ctrl+F5)
3. Clear Laravel cache
4. Check file permissions (chmod 644)
5. Verify file format (PNG recommended)

### Warna Tidak Berubah

**Problem**: Warna masih menggunakan warna lama

**Solutions**:
1. Clear Laravel config cache: `php artisan config:clear`
2. Clear browser cache
3. Check CSS specificity (might need `!important`)
4. Verify CSS file is loaded in layout
5. Check browser DevTools for loaded CSS

### Background Image Tidak Muncul

**Problem**: Background image tidak terlihat

**Solutions**:
1. Check file size (max 2MB)
2. Verify file path in branding.json
3. Check CSS background property
4. Verify file permissions
5. Try different image format

### Font Tidak Berubah

**Problem**: Font masih menggunakan font default

**Solutions**:
1. Check Google Fonts link in <head>
2. Verify font name spelling
3. Check CSS font-family property
4. Clear browser cache
5. Use DevTools to see loaded fonts

---

## 📱 Contact Support

Jika mengalami kesulitan dalam kustomisasi:

**Email**: support@yourapp.com  
**WhatsApp**: +62 812-3456-7890  
**Documentation**: https://docs.yourapp.com  
**Video Tutorial**: https://youtube.com/tutorials

---

**Last Updated**: 2025-10-14  
**Version**: 1.0  
**Maintained By**: Development Team