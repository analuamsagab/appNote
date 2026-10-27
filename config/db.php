<?php
declare(strict_types=1);

/*
 * Konfigurasi koneksi database.
 * Pastikan MySQL XAMPP sudah berjalan dan database sudah diimpor
 * dari database.sql sebelum membuka aplikasi.
 */
$dbHost = '127.0.0.1';
$dbUser = 'catatan_user';
$dbPass = 'catatan_app_2026';
$dbName = 'catatan_app';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $db->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Pastikan MySQL XAMPP sudah berjalan dan database "catatan_app" sudah diimpor.');
}
