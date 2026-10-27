<?php
require_once __DIR__ . '/functions.php';

$base = $base ?? '';
$pageTitle = $pageTitle ?? 'Catatan Sederhana';
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= e($base) ?>assets/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?= e($base) ?>index.php">
                <span class="brand-mark" aria-hidden="true">C</span>
                Catatan Sederhana
            </a>
            <nav class="nav" aria-label="Navigasi utama">
                <a href="<?= e($base) ?>index.php">Beranda</a>
                <?php if (!empty($_SESSION['admin_id'])): ?>
                    <a href="<?= e($base) ?>admin/dashboard.php">Dashboard</a>
                    <a href="<?= e($base) ?>admin/logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?= e($base) ?>admin/login.php">Login Admin</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if ($flash !== null): ?>
            <div class="flash flash-<?= e($flash['type']) ?>" role="<?= $flash['type'] === 'error' ? 'alert' : 'status' ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>
