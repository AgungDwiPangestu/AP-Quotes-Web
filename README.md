# 🌟 Ap Quotes Web

Platform berbagi kutipan dan pemikiran inspiratif yang modern dan responsif.

## 📋 Deskripsi

Ap Quotes adalah aplikasi web berbasis PHP yang memungkinkan pengguna untuk:

- 📝 Membuat dan membagikan kutipan inspiratif
- ❤️ Menyukai post dari pengguna lain
- 💬 Memberikan komentar pada post
- 👤 Mengelola profil pribadi
- 🔐 Sistem autentikasi yang aman

## 🚀 Fitur Utama

### Untuk Pengguna

- ✅ Registrasi dan Login yang aman
- ✅ Buat, Edit, dan Hapus post pribadi
- ✅ Like dan Unlike post
- ✅ Komentar pada post
- ✅ Edit profil pengguna
- ✅ Lihat post pribadi
- ✅ Session timeout otomatis (15 menit)

### Untuk Admin

- ✅ Hapus post dari pengguna mana pun
- ✅ Moderasi konten

## 📁 Struktur Folder Baru

```
ApQuotesWeb/
├── config/              # Konfigurasi aplikasi
│   ├── config.php      # Konfigurasi umum
│   └── database.php    # Koneksi database
├── includes/           # File include template
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── pages/             # Halaman-halaman aplikasi
├── actions/           # File aksi/proses
├── assets/            # Asset statis
│   ├── css/          # Stylesheet
│   ├── js/           # JavaScript
│   └── images/       # Gambar
└── index.php         # Halaman utama
```

## ⚙️ Instalasi

1. **Konfigurasi Database**
   Edit `config/database.php` dengan kredensial database Anda.

2. **Login Admin Default**

   ```
   Username: apadmin
   Password: apadmin
   ```

3. **Akses**: http://localhost/ApQuotesWeb

## 🎨 Fitur Design

- Modern & Clean UI
- Fully Responsive
- Mobile-First Approach
- Font Awesome Icons
- Smooth Animations

## 👨‍💻 Author

**apqGuns**

- GitHub: [@apqGuns](https://github.com/apqGuns)
- Email: CreateQuotes@gmail.com

Made with ❤️ by apqGuns
