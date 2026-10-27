<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$q = mb_substr($q, 0, 100);

if ($q !== '') {
    $stmt = $db->prepare('SELECT id, judul, isi, created_at FROM notes WHERE judul LIKE ? OR isi LIKE ? ORDER BY created_at DESC, id DESC');
    $like = '%' . $q . '%';
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $notes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $notes = $db->query('SELECT id, judul, isi, created_at FROM notes ORDER BY created_at DESC, id DESC')->fetch_all(MYSQLI_ASSOC);
}

$total = count($notes);
$base = '';
$pageTitle = 'Beranda · Catatan Sederhana';
require __DIR__ . '/includes/header.php';
?>
        <section class="hero">
            <div>
                <p class="eyebrow">Catatan harian</p>
                <h1>Catatan Sederhana</h1>
                <p class="hero-text">Tulis ide, rencana, dan hal-hal kecil yang ingin Anda ingat.</p>
            </div>
            <?php if (!empty($_SESSION['admin_id'])): ?>
                <a class="btn btn-primary" href="admin/tambah.php">+ Catatan Baru</a>
            <?php endif; ?>
        </section>

        <form class="search" method="get" action="index.php" role="search">
            <label class="visually-hidden" for="q">Cari catatan</label>
            <input type="search" id="q" name="q" value="<?= e($q) ?>" placeholder="Cari judul atau isi catatan..." maxlength="100">
            <button class="btn" type="submit">Cari</button>
            <?php if ($q !== ''): ?>
                <a class="btn btn-ghost" href="index.php">Reset</a>
            <?php endif; ?>
        </form>

        <div class="list-head">
            <p>
                <?php if ($q !== ''): ?>
                    <?= $total ?> hasil untuk &ldquo;<?= e($q) ?>&rdquo;
                <?php else: ?>
                    <?= $total ?> catatan tersimpan
                <?php endif; ?>
            </p>
            <?php if ($q !== ''): ?>
                <a href="index.php">Hapus pencarian</a>
            <?php endif; ?>
        </div>

        <?php if ($notes): ?>
            <div class="note-grid">
                <?php foreach ($notes as $note): ?>
                    <article class="note-card">
                        <h2>
                            <a href="catatan.php?id=<?= (int) $note['id'] ?>"><?= e($note['judul']) ?></a>
                        </h2>
                        <p class="meta">
                            <time datetime="<?= date('Y-m-d', strtotime($note['created_at'])) ?>">
                                <?= e(format_tanggal($note['created_at'])) ?>
                            </time>
                        </p>
                        <p class="excerpt"><?= e(excerpt($note['isi'])) ?></p>
                        <a class="read-more" href="catatan.php?id=<?= (int) $note['id'] ?>">Baca selengkapnya &rarr;</a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <?php if ($q !== ''): ?>
                    <h2>Tidak ada hasil</h2>
                    <p>Tidak ada catatan yang cocok dengan &ldquo;<?= e($q) ?>&rdquo;. Coba kata kunci lain.</p>
                    <a class="btn" href="index.php">Kembali ke semua catatan</a>
                <?php else: ?>
                    <h2>Belum ada catatan</h2>
                    <p>Mulai dengan membuat catatan pertama Anda.</p>
                    <?php if (!empty($_SESSION['admin_id'])): ?>
                        <a class="btn btn-primary" href="admin/tambah.php">+ Tambah Catatan</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="admin/login.php">Login untuk menambah catatan</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
