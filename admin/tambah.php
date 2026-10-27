<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

$judul = '';
$isi = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $judul = trim((string) ($_POST['judul'] ?? ''));
    $isi = trim((string) ($_POST['isi'] ?? ''));

    if ($judul === '') {
        $errors[] = 'Judul wajib diisi.';
    } elseif (mb_strlen($judul) > 150) {
        $errors[] = 'Judul maksimal 150 karakter.';
    }

    if ($isi === '') {
        $errors[] = 'Isi catatan wajib diisi.';
    }

    if (!$errors) {
        $stmt = $db->prepare('INSERT INTO notes (judul, isi) VALUES (?, ?)');
        $stmt->bind_param('ss', $judul, $isi);
        $stmt->execute();

        set_flash('success', 'Catatan baru berhasil disimpan.');
        redirect('dashboard.php');
    }
}

$base = '../';
$pageTitle = 'Tambah Catatan · Catatan Sederhana';
$formAction = 'tambah.php';
$submitLabel = 'Simpan Catatan';
require __DIR__ . '/../includes/header.php';
?>
        <section class="page-head">
            <p class="eyebrow">Area admin</p>
            <h1>Tambah Catatan</h1>
            <p class="hero-text">Tulis judul dan isi catatan baru.</p>
        </section>

        <?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
