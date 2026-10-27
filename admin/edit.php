<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash('error', 'Catatan tidak ditemukan.');
    redirect('dashboard.php');
}

$stmt = $db->prepare('SELECT id, judul, isi FROM notes WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$note = $stmt->get_result()->fetch_assoc();

if ($note === null) {
    set_flash('error', 'Catatan tidak ditemukan.');
    redirect('dashboard.php');
}

$judul = $note['judul'];
$isi = $note['isi'];
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
        $stmt = $db->prepare('UPDATE notes SET judul = ?, isi = ? WHERE id = ?');
        $stmt->bind_param('ssi', $judul, $isi, $id);
        $stmt->execute();

        set_flash('success', 'Catatan berhasil diperbarui.');
        redirect('dashboard.php');
    }
}

$base = '../';
$pageTitle = 'Edit Catatan · Catatan Sederhana';
$formAction = 'edit.php?id=' . $id;
$submitLabel = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
        <section class="page-head">
            <p class="eyebrow">Area admin</p>
            <h1>Edit Catatan</h1>
            <p class="hero-text">Perbarui judul atau isi catatan, lalu simpan perubahan.</p>
        </section>

        <?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
