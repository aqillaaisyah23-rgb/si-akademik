<h1 class="mb-4">Edit Mahasiswa</h1>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="<?= BASE_PATH ?>/mahasiswa/<?= $mahasiswa->getId() ?>/update" method="POST">
  <div class="mb-3">
    <label class="form-label">NIM</label>
    <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($mahasiswa->getNim()) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($mahasiswa->getNama()) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($mahasiswa->getEmail()) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Program Studi</label>
    <select name="prodi_id" class="form-select" required>
      <?php foreach ($prodi as $p): ?>
        <option value="<?= $p->getId() ?>" <?= $p->getId() === $mahasiswa->getProdiId() ? 'selected' : '' ?>>
          <?= htmlspecialchars($p->getNama()) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Angkatan</label>
    <input type="number" name="angkatan" class="form-control" value="<?= $mahasiswa->getAngkatan() ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php foreach (['aktif', 'cuti', 'lulus', 'nonaktif'] as $s): ?>
        <option value="<?= $s ?>" <?= $s === $mahasiswa->getStatus() ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <a href="<?= BASE_PATH ?>/mahasiswa" class="btn btn-secondary">Batal</a>
</form>
