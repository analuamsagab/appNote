-- ============================================================
-- Database: Catatan Sederhana
-- Import lewat phpMyAdmin, atau lewat terminal:
--   C:\xampp\mysql\bin\mysql.exe -u catatan_user -p catatan_app < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS catatan_app
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE catatan_app;

DROP TABLE IF EXISTS notes;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    isi TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Akun admin default: admin / admin123
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$cQlfDD4QfWA4Ih0fM9mWNuU63pueHgbr8U/8Tyi2YGaIbzWPGKaaC');

-- Catatan contoh
INSERT INTO notes (judul, isi, created_at, updated_at) VALUES
('Selamat datang di Catatan Sederhana',
 'Ini adalah catatan contoh pertama. Anda bisa membaca catatan ini tanpa login, tetapi untuk menambah, mengubah, atau menghapus catatan Anda perlu masuk sebagai admin.

Klik tombol Login Admin di pojok kanan atas, lalu gunakan akun demo:
username: admin
password: admin123

Setelah login, Anda akan melihat dashboard untuk mengelola semua catatan.',
 NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),

('Ide untuk akhir pekan',
 'Beberapa hal kecil yang bisa dicoba saat akhir pekan:

1. Jalan pagi di sekitar kompleks.
2. Membaca satu bab buku yang sudah lama menganggur.
3. Mencoba resep masakan baru.
4. Merapikan meja kerja dan menyortir barang yang tidak terpakai.

Tidak perlu semuanya. Pilih satu atau dua saja supaya tetap santai.',
 NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),

('Belanja bulanan',
 'Daftar belanja bulan ini:

- Beras dan minyak goreng
- Telur, sayur, dan buah
- Sabun, sampo, dan pasta gigi
- Kopi dan teh
- Alat tulis untuk meja kerja

Periksa stok di rumah sebelum berangkat supaya tidak membeli barang yang masih banyak.',
 NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY);
