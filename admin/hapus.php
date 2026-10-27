<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('dashboard.php');
}

csrf_check();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('error', 'Catatan tidak ditemukan.');
    redirect('dashboard.php');
}

$stmt = $db->prepare('DELETE FROM notes WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    set_flash('success', 'Catatan berhasil dihapus.');
} else {
    set_flash('error', 'Catatan tidak ditemukan atau sudah dihapus.');
}

redirect('dashboard.php');
