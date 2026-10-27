<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}

$username = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    } else {
        $stmt = $db->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user !== null && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            set_flash('success', 'Selamat datang, ' . $user['username'] . '.');
            redirect('dashboard.php');
        }

        $errors[] = 'Username atau password salah.';
    }
}

$base = '../';
$pageTitle = 'Login Admin · Catatan Sederhana';
require __DIR__ . '/../includes/header.php';
?>
        <div class="auth-wrap">
            <section class="auth-card">
                <p class="eyebrow">Area admin</p>
                <h1>Masuk</h1>
                <p class="auth-intro">Login untuk menambah, mengubah, dan menghapus catatan.</p>

                <?php if ($errors): ?>
                    <div class="alert" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <p><?= e($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="login.php" class="form">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= e($username) ?>" autocomplete="username" required autofocus>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </form>

                <div class="hint">
                    <strong>Akun demo:</strong> admin / admin123
                </div>
            </section>
        </div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
