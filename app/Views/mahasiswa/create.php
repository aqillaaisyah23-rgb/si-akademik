<h1 class="mb-4">Tambah Mahasiswa</h1>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="<?= BASE_PATH ?>/mahasiswa" method="POST">
  <div class="mb-3">
    <label class="form-label">NIM</label>
    <input type="text" name="nim" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Program Studi</label>
    <select name="prodi_id" class="form-select" required>
      <option value="">-- Pilih Prodi --</option>
      <?php foreach ($prodi as $p): ?>
        <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getNama()) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Angkatan</label>
    <input type="number" name="angkatan" class="form-control" value="<?= date('Y') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="aktif">Aktif</option>
      <option value="cuti">Cuti</option>
      <option value="lulus">Lulus</option>
      <option value="nonaktif">Nonaktif</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= BASE_PATH ?>/mahasiswa" class="btn btn-secondary">Batal</a>
</form>
