# Catatan Sederhana

Aplikasi catatan sederhana menggunakan **HTML, PHP prosedural (mysqli), dan MySQL/MariaDB**. Tanpa framework, tanpa Composer, tanpa build tool.

## Fitur

- Daftar catatan untuk publik
- Pencarian judul dan isi catatan
- Halaman detail catatan
- Login admin (password di-hash)
- Tambah, edit, dan hapus catatan
- Proteksi CSRF pada form
- Tampilan responsif dengan satu file CSS

## Kebutuhan

- XAMPP (PHP 8.2 dan MySQL/MariaDB) — sudah terpasang di `C:\xampp`
- Browser modern

## Cara Menjalankan

1. Buka **XAMPP Control Panel**, lalu start **MySQL**.
2. Pastikan database dan user sudah dibuat (sekali saja):

   ```sql
   CREATE DATABASE catatan_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'catatan_user'@'localhost' IDENTIFIED BY 'catatan_app_2026';
   GRANT ALL PRIVILEGES ON catatan_app.* TO 'catatan_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. Impor skema dan data contoh:

   > **Perhatian:** `database.sql` menjalankan `DROP TABLE`, jadi mengimpor ulang akan menghapus semua catatan yang sudah ada.

   ```powershell
   cmd /c "C:\xampp\mysql\bin\mysql.exe -u catatan_user -pcatatan_app_2026 catatan_app < database.sql"
   ```

4. Jalankan PHP built-in server dari folder proyek:

   ```powershell
   C:\xampp\php\php.exe -S localhost:8000 -t C:\Users\User\Desktop\app-bosok
   ```

5. Buka <http://localhost:8000>.

## Akun Admin

- Username: `admin`
- Password: `admin123`

## Struktur Folder

```
app-bosok/
├─ database.sql
├─ config/db.php
├─ includes/
│  ├─ auth.php
│  ├─ footer.php
│  ├─ functions.php
│  └─ header.php
├─ assets/style.css
├─ index.php
├─ catatan.php
└─ admin/
   ├─ _form.php
   ├─ dashboard.php
   ├─ edit.php
   ├─ hapus.php
   ├─ login.php
   ├─ logout.php
   └─ tambah.php
```

## Catatan Keamanan

- Kredensial database ada di `config/db.php`. Ganti password user database sebelum dipakai di luar komputer lokal.
- Ganti password admin (hash dibuat dengan `password_hash`) jika aplikasi dipakai publik.
- Semua query memakai prepared statement; output di-escape dengan `htmlspecialchars`.
