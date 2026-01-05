# Dokumentasi Struktur File ApQuotesWeb

## 📂 Struktur Folder Lengkap

### Root Directory

```
ApQuotesWeb/
├── index.php                 # Halaman utama (beranda)
├── README.md                 # Dokumentasi utama
├── .gitignore               # File yang diabaikan Git
└── [legacy files]           # File lama (akan dipindahkan)
```

### Config Directory (`config/`)

Berisi file konfigurasi aplikasi:

- `config.php` - Konfigurasi umum (timezone, session, site settings)
- `database.php` - Koneksi database dan setup tabel
- `database.php.example` - Template konfigurasi database

### Includes Directory (`includes/`)

File template dan helper yang digunakan di seluruh aplikasi:

- `header.php` - Template header (navigation, flash messages)
- `footer.php` - Template footer
- `functions.php` - Helper functions (sanitize, auth, format, etc.)

### Pages Directory (`pages/`)

**Akan berisi halaman-halaman aplikasi:**

#### Authentication Pages

- `login.php` - Halaman login
- `register.php` - Halaman registrasi

#### Post Management Pages

- `create_post.php` - Form buat post baru
- `edit_post.php` - Form edit post
- `my_posts.php` - Daftar post milik user

#### Profile Pages

- `my_profile.php` - Halaman profil user
- `edit_profile.php` - Form edit profil

### Actions Directory (`actions/`)

**Akan berisi file proses/action:**

#### Authentication Actions

- `login_action.php` - Proses login
- `register_action.php` - Proses registrasi
- `logout.php` - Proses logout

#### Post Actions

- `create_post_action.php` - Proses buat post
- `delete_post.php` - Proses hapus post
- `like_action.php` - Proses like post (deprecated, use AJAX)
- `unlike_post.php` - Proses unlike post (deprecated, use AJAX)

#### Comment Actions

- `comment_action.php` - Proses tambah komentar
- `get_comments.php` - Get komentar via AJAX

#### AJAX Actions

- `like_post.php` - Toggle like via AJAX
- `unlike_post.php` - Toggle unlike via AJAX

### Assets Directory (`assets/`)

#### CSS (`assets/css/`)

- `main.css` - Stylesheet utama (colors, layout, components)
- `responsive.css` - Media queries dan responsive styles

#### JavaScript (`assets/js/`)

- `main.js` - JavaScript utama (AJAX, DOM manipulation, utilities)

#### Images (`assets/images/`)

- `uploads/` - Folder untuk upload gambar user
  - `.gitkeep` - File penanda agar folder tetap di Git

## 📋 File yang Perlu Dibuat/Dipindahkan

### Priority 1: Authentication (LOGIN/REGISTER)

```
pages/login.php          ← dari login.php (root)
pages/register.php       ← dari register.php (root)
actions/login_action.php ← dari login_action.php (root)
actions/register_action.php ← dari register_action.php (root)
actions/logout.php       ← dari logout.php (root)
```

### Priority 2: Post Management

```
pages/create_post.php    ← dari create_post.php (root)
pages/edit_post.php      ← dari edit_post.php (root)
pages/my_posts.php       ← dari my_post.php (root)
actions/create_post_action.php ← dari create_post_action.php (root)
actions/delete_post.php  ← dari delete_post.php (root)
```

### Priority 3: Profile

```
pages/my_profile.php     ← dari my_profile.php (root)
pages/edit_profile.php   ← dari edit_profile.php (root)
```

### Priority 4: Interactions

```
actions/comment_action.php ← dari comment_action.php (root)
actions/like_action.php    ← dari like_action.php (root)
actions/like_post.php      ← dari like_post.php (root)
actions/unlike_post.php    ← dari unlike_post.php (root)
```

### CSS Files (akan diganti)

```
assets/css/main.css       → ganti style.css (root)
assets/css/responsive.css → ganti *-style.css files
```

## 🔄 Path Changes Required

Setelah file dipindahkan, update include/require paths:

### From Root Files

```php
// OLD
require_once('koneksi.php');
include('header.php');

// NEW
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
```

### From Pages Directory

```php
// In pages/*.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
```

### From Actions Directory

```php
// In actions/*.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
// No header/footer needed in action files
```

## 🎨 CSS/JS References

### In Header File

```html
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="stylesheet" href="assets/css/responsive.css" />
```

### In Footer File

```html
<script src="assets/js/main.js"></script>
```

### From Pages Directory

```html
<link rel="stylesheet" href="../assets/css/main.css" />
<script src="../assets/js/main.js"></script>
```

## 🚀 Next Steps

1. ✅ Struktur folder dibuat
2. ✅ Config files dibuat
3. ✅ Includes files (header, footer, functions) dibuat
4. ✅ CSS modern dibuat
5. ✅ JavaScript file dibuat
6. ✅ index.php diperbaiki
7. ⏳ Pindahkan dan update file authentication
8. ⏳ Pindahkan dan update file post management
9. ⏳ Pindahkan dan update file profile
10. ⏳ Pindahkan dan update file actions
11. ⏳ Testing semua fungsi
12. ⏳ Hapus file lama

## ⚠️ Notes

- Semua file lama tetap ada di root sampai migrasi selesai
- File `.old` adalah backup dari file yang sudah dimodifikasi
- Setelah testing, file lama bisa dihapus
- Pastikan path relatif benar saat memindahkan file
- Test setiap fitur setelah memindahkan file terkait

## 📞 Troubleshooting

### Error: Cannot find file

- Check path relatif (`../` untuk naik 1 level)
- Gunakan `__DIR__` untuk absolute path
- Periksa case sensitivity di nama file

### CSS/JS not loading

- Check path di tag `<link>` dan `<script>`
- Clear browser cache
- Check browser console untuk error

### Database connection error

- Periksa config/database.php
- Pastikan MySQL service running
- Check credentials database
