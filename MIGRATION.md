# 📦 Panduan Migrasi File - Ap Quotes Web

## 🎯 Status Saat Ini

### ✅ Sudah Selesai

- [x] Struktur folder dibuat
- [x] Config files (config.php, database.php)
- [x] Include files (header.php, footer.php, functions.php)
- [x] CSS modern (main.css, responsive.css)
- [x] JavaScript (main.js)
- [x] index.php diperbaiki
- [x] Dokumentasi lengkap

### ⏳ Perlu Dipindahkan

File-file ini masih di root directory dan perlu dipindahkan:

## 📋 Daftar File yang Perlu Dipindahkan

### 1. Authentication Pages (Priority: HIGH)

```
✅ STEP 1: Copy & Update
login.php           → pages/login.php
register.php        → pages/register.php

✅ STEP 2: Move Actions
login_action.php    → actions/login_action.php
register_action.php → actions/register_action.php
logout.php          → actions/logout.php
```

### 2. Post Management (Priority: HIGH)

```
✅ STEP 3: Copy Pages
create_post.php     → pages/create_post.php
edit_post.php       → pages/edit_post.php
my_post.php         → pages/my_posts.php

✅ STEP 4: Move Actions
create_post_action.php → actions/create_post_action.php
delete_post.php     → actions/delete_post.php
```

### 3. Profile Pages (Priority: MEDIUM)

```
✅ STEP 5: Copy Pages
my_profile.php      → pages/my_profile.php
edit-profile.php    → pages/edit_profile.php
```

### 4. Interaction Actions (Priority: MEDIUM)

```
✅ STEP 6: Move Actions
comment_action.php  → actions/comment_action.php
like_action.php     → actions/like_action.php
like_post.php       → actions/like_post.php
unlike_post.php     → actions/unlike_post.php
```

### 5. Old Files (Priority: LOW)

```
✅ STEP 7: Archive or Delete
header.php          → includes/header.php (sudah dibuat baru)
footer.php          → includes/footer.php (sudah dibuat baru)
koneksi.php         → config/database.php (sudah dibuat baru)
style.css           → assets/css/main.css (sudah dibuat baru)
create-post-style.css → (tidak diperlukan lagi)
edit-profile-style.css → (tidak diperlukan lagi)
my-posts-style.css  → (tidak diperlukan lagi)
my-profile-style.css → (tidak diperlukan lagi)
index.php.old       → (backup, bisa dihapus setelah testing)
```

## 🔧 Cara Migrasi File

### Template untuk Pages

```php
<?php
// File: pages/nama_file.php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Check authentication jika diperlukan
if (!is_logged_in()) {
    redirect('../pages/login.php');
}

// Your page logic here...

$page_title = 'Title Halaman';
include __DIR__ . '/../includes/header.php';
?>

<!-- Your HTML content here -->

<?php
include __DIR__ . '/../includes/footer.php';
?>
```

### Template untuk Actions

```php
<?php
// File: actions/nama_action.php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Check authentication
if (!is_logged_in()) {
    redirect('../pages/login.php');
}

// Process form...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your action logic here...

    // Redirect dengan message
    redirect('../index.php', 'Success message', 'success');
}

// If not POST, redirect back
redirect('../index.php');
?>
```

## 📝 Checklist Untuk Setiap File

Saat memindahkan file, pastikan:

### 1. Update Path Includes

- [ ] `require_once()` path sudah benar
- [ ] `include()` path sudah benar
- [ ] Gunakan `__DIR__` untuk relative path

### 2. Update Form Actions

- [ ] `<form action="">` path sudah update
- [ ] `header('Location:')` path sudah update

### 3. Update Asset Paths

- [ ] CSS links (`<link href="">`)
- [ ] JS scripts (`<script src="">`)
- [ ] Image sources (`<img src="">`)

### 4. Update Navigation Links

- [ ] `<a href="">` semua link sudah update
- [ ] Relative path dari folder baru

### 5. Testing

- [ ] File bisa diakses tanpa error
- [ ] Form submission bekerja
- [ ] Redirect bekerja dengan benar
- [ ] CSS/JS load dengan benar

## 🎯 Prioritas Eksekusi

### Phase 1: Core Authentication (Hari 1)

1. Login & Register pages
2. Login & Register actions
3. Logout action
4. **TEST**: Login/Logout/Register flow

### Phase 2: Main Features (Hari 2)

1. Create post page & action
2. Edit post page
3. Delete post action
4. My posts page
5. **TEST**: CRUD posts

### Phase 3: Interactions (Hari 3)

1. Like/Unlike actions
2. Comment action
3. **TEST**: Like & Comment features

### Phase 4: Profile (Hari 4)

1. My profile page
2. Edit profile page
3. **TEST**: Profile features

### Phase 5: Cleanup (Hari 5)

1. Test semua fitur end-to-end
2. Fix bugs jika ada
3. Hapus file lama
4. Commit ke Git

## 🚨 Yang TIDAK Perlu Dipindahkan

File-file ini bisa langsung dihapus karena sudah diganti:

- ❌ `style.css` → Diganti `assets/css/main.css`
- ❌ `*-style.css` → Diganti `assets/css/responsive.css`
- ❌ `koneksi.php` → Diganti `config/database.php`
- ❌ `header.php` (root) → Diganti `includes/header.php`
- ❌ `footer.php` (root) → Diganti `includes/footer.php`
- ❌ `index.php.old` → Backup, bisa dihapus

## 📌 Quick Reference

### Path dari Root

```php
require_once __DIR__ . '/config/config.php';
include __DIR__ . '/includes/header.php';
```

### Path dari Pages

```php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../includes/header.php';
```

### Path dari Actions

```php
require_once __DIR__ . '/../config/config.php';
// No header/footer in actions
```

### Form Actions dari Pages

```html
<form action="../actions/nama_action.php" method="POST"></form>
```

### Assets dari Pages

```html
<link rel="stylesheet" href="../assets/css/main.css" />
<script src="../assets/js/main.js"></script>
```

## 🎓 Tips

1. **Backup First**: Selalu backup sebelum mengubah
2. **One at a Time**: Pindahkan satu file, test, lalu lanjut
3. **Use Git**: Commit setelah setiap file berhasil
4. **Test Thoroughly**: Test setiap fungsi setelah migrasi
5. **Keep Old Files**: Jangan hapus file lama sampai semua work

## 🆘 Troubleshooting

### "Failed to open stream: No such file or directory"

→ Path salah, check `require_once` dan `include` paths

### "Undefined function"

→ Lupa include `functions.php`

### "Call to a member function on null"

→ Database connection gagal, check `config/database.php`

### CSS tidak muncul

→ Path CSS salah, check `<link>` tag

### Form submit tidak work

→ Form action path salah, check `<form action="">`

---

## ✅ Next Action

Mulai dengan Phase 1 (Authentication):

1. Copy `login.php` ke `pages/`
2. Update paths di file tersebut
3. Test login flow
4. Jika work, lanjut ke file berikutnya

**Good luck!** 🚀
