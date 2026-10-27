<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

if (empty($_SESSION['admin_id'])) {
    set_flash('error', 'Silakan login terlebih dahulu untuk mengelola catatan.');
    redirect('login.php');
}
