<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$base = '';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$note = null;

if ($id) {
    $stmt = $db->prepare('SELECT id, judul, isi, created_at, updated_at FROM notes WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $note = $stmt->get_result()->fetch_assoc();
}

if ($note === null) {
    http_response_code(404);
    $pageTitle = 'Catatan Tidak Ditemukan · Catatan Sederhana';
    require __DIR__ . '/includes/header.php';
    ?>
        <div class="empty-state">
            <p class="eyebrow">404</p>
            <h1>Catatan tidak ditemukan</h1>
            <p>Catatan yang Anda cari mungkin sudah dihapus atau alamatnya salah.</p>
            <a class="btn btn-primary" href="index.php">Kembali ke Beranda</a>
        </div>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $note['judul'] . ' · Catatan Sederhana';
require __DIR__ . '/includes/header.php';
?>
        <article class="note-detail">
            <a class="back-link" href="index.php">&larr; Kembali ke daftar</a>
            <h1><?= e($note['judul']) ?></h1>
            <p class="meta">
                Dibuat <?= e(format_tanggal($note['created_at'])) ?>
                <?php if ($note['updated_at'] !== $note['created_at']): ?>
                    &middot; Diperbarui <?= e(format_tanggal($note['updated_at'])) ?>
                <?php endif; ?>
            </p>
            <div class="note-body"><?= nl2br(e($note['isi'])) ?></div>

            <?php if (!empty($_SESSION['admin_id'])): ?>
                <div class="detail-actions">
                    <a class="btn" href="admin/edit.php?id=<?= (int) $note['id'] ?>">Edit Catatan</a>
                </div>
            <?php endif; ?>
        </article>
<?php require __DIR__ . '/includes/footer.php'; ?>
