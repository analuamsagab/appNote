<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

$notes = $db->query('SELECT id, judul, created_at, updated_at FROM notes ORDER BY updated_at DESC, id DESC')->fetch_all(MYSQLI_ASSOC);

$base = '../';
$pageTitle = 'Dashboard · Catatan Sederhana';
require __DIR__ . '/../includes/header.php';
?>
        <section class="hero compact">
            <div>
                <p class="eyebrow">Area admin</p>
                <h1>Dashboard Catatan</h1>
                <p class="hero-text"><?= count($notes) ?> catatan tersimpan. Kelola semuanya dari sini.</p>
            </div>
            <a class="btn btn-primary" href="tambah.php">+ Tambah Catatan</a>
        </section>

        <?php if (!$notes): ?>
            <div class="empty-state">
                <h2>Belum ada catatan</h2>
                <p>Mulai dengan membuat catatan pertama Anda.</p>
                <a class="btn btn-primary" href="tambah.php">+ Tambah Catatan</a>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Judul</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                            <th scope="col" class="actions-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td class="title-cell">
                                    <a href="../catatan.php?id=<?= (int) $note['id'] ?>"><?= e($note['judul']) ?></a>
                                </td>
                                <td><?= e(format_tanggal($note['created_at'], false)) ?></td>
                                <td><?= e(format_tanggal($note['updated_at'], false)) ?></td>
                                <td>
                                    <div class="row-actions">
                                        <a class="btn btn-small" href="edit.php?id=<?= (int) $note['id'] ?>">Edit</a>
                                        <form method="post" action="hapus.php" onsubmit="return confirm('Hapus catatan ini? Tindakan tidak bisa dibatalkan.');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= (int) $note['id'] ?>">
                                            <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
