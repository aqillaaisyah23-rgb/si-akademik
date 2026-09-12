<h1 class="mb-4">Detail Mahasiswa</h1>

<table class="table table-bordered w-auto">
  <tr><th>NIM</th><td><?= htmlspecialchars($mahasiswa->getNim()) ?></td></tr>
  <tr><th>Nama</th><td><?= htmlspecialchars($mahasiswa->getNama()) ?></td></tr>
  <tr><th>Email</th><td><?= htmlspecialchars($mahasiswa->getEmail()) ?></td></tr>
  <tr><th>Prodi</th><td><?= htmlspecialchars($mahasiswa->getProdiNama() ?? '-') ?></td></tr>
  <tr><th>Angkatan</th><td><?= $mahasiswa->getAngkatan() ?></td></tr>
  <tr><th>Status</th><td><?= htmlspecialchars($mahasiswa->getStatus()) ?></td></tr>
</table>

<a href="<?= BASE_PATH ?>/mahasiswa" class="btn btn-secondary">Kembali</a>
