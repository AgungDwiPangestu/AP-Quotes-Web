# 🚀 Panduan Instalasi Cepat - Ap Quotes Web

## Langkah 1: Persiapan Database

### Opsi A: Otomatis (Rekomendasi)

File akan otomatis membuat database dan tabel saat pertama kali diakses.

### Opsi B: Manual

```sql
CREATE DATABASE ap_quotes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Langkah 2: Konfigurasi Database

Edit file `config/database.php`:

```php
define('DB_HOST', 'localhost');        // Host database
define('DB_USER', 'root');             // Username database
define('DB_PASS', 'your_password');    // Password database
define('DB_NAME', 'ap_quotes');        // Nama database
```

## Langkah 3: Setup Web Server

### Menggunakan XAMPP/WAMP

1. Copy folder `ApQuotesWeb` ke `htdocs` (XAMPP) atau `www` (WAMP)
2. Akses: `http://localhost/ApQuotesWeb`

### Menggunakan PHP Built-in Server

```bash
cd ApQuotesWeb
php -S localhost:8000
```

Akses: `http://localhost:8000`

## Langkah 4: Login Pertama Kali

### Akun Admin Default

```
Username: apadmin
Password: apadmin
```

⚠️ **PENTING**: Ubah password segera setelah login pertama!

## Langkah 5: Testing

1. ✅ Login dengan akun admin
2. ✅ Buat post pertama
3. ✅ Test fitur like
4. ✅ Test fitur comment
5. ✅ Buat akun user baru
6. ✅ Edit profil

## ⚙️ Konfigurasi Tambahan (Opsional)

### Ubah Session Timeout

File: `config/config.php`

```php
define('SESSION_TIMEOUT', 900);  // 900 detik = 15 menit
```

### Ubah Timezone

File: `config/config.php`

```php
date_default_timezone_set('Asia/Jakarta');  // Sesuaikan zona waktu
```

### Upload Settings

File: `config/config.php`

```php
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);  // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);
```

## 🐛 Troubleshooting

### Error: "Connection failed"

- ✅ Periksa MySQL service sudah running
- ✅ Cek username dan password database di `config/database.php`
- ✅ Pastikan database `ap_quotes` sudah dibuat

### Error: "Cannot find file"

- ✅ Pastikan semua folder sudah ada
- ✅ Periksa permission folder (755 untuk folder, 644 untuk file)

### CSS/JS tidak muncul

- ✅ Clear cache browser (Ctrl+F5)
- ✅ Periksa path di source code (F12 → Network tab)
- ✅ Pastikan folder `assets` accessible

### Session timeout terlalu cepat

- ✅ Ubah nilai `SESSION_TIMEOUT` di `config/config.php`
- ✅ Check PHP session settings di `php.ini`

## 📞 Bantuan

Jika masih ada masalah:

1. Baca `README.md` untuk dokumentasi lengkap
2. Baca `STRUCTURE.md` untuk memahami struktur file
3. Buka issue di GitHub
4. Email: CreateQuotes@gmail.com

## ✨ Selamat!

Website Ap Quotes Anda sudah siap digunakan! 🎉

Jangan lupa:

- 🔐 Ubah password admin
- 📝 Buat post pertama Anda
- 🎨 Customize sesuai kebutuhan

Happy coding! 💻
