<h1 class="mb-4">Daftar Mahasiswa</h1>

<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<a href="<?= BASE_PATH ?>/mahasiswa/create" class="btn btn-primary mb-3">Tambah Mahasiswa</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>NIM</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Prodi</th>
      <th>Angkatan</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($mahasiswa)): ?>
      <tr><td colspan="7" class="text-center">Belum ada data mahasiswa.</td></tr>
    <?php else: ?>
      <?php foreach ($mahasiswa as $m): ?>
        <tr>
          <td><?= htmlspecialchars($m->getNim()) ?></td>
          <td><?= htmlspecialchars($m->getNama()) ?></td>
          <td><?= htmlspecialchars($m->getEmail()) ?></td>
          <td><?= htmlspecialchars($m->getProdiNama() ?? '-') ?></td>
          <td><?= $m->getAngkatan() ?></td>
          <td><?= htmlspecialchars($m->getStatus()) ?></td>
          <td>
            <a href="<?= BASE_PATH ?>/mahasiswa/<?= $m->getId() ?>/edit" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= BASE_PATH ?>/mahasiswa/<?= $m->getId() ?>/delete" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus data mahasiswa ini?');">
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
