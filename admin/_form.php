<?php if ($errors): ?>
    <div class="alert" role="alert">
        <?php foreach ($errors as $error): ?>
            <p><?= e($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($formAction) ?>" class="form card">
    <?= csrf_field() ?>

    <div class="field">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="<?= e($judul) ?>" maxlength="150" required autofocus>
        <p class="field-hint">Maksimal 150 karakter.</p>
    </div>

    <div class="field">
        <label for="isi">Isi catatan</label>
        <textarea id="isi" name="isi" rows="12" required><?= e($isi) ?></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
        <a class="btn btn-ghost" href="dashboard.php">Batal</a>
    </div>
</form>
