<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_PATH ?>/dashboard">SI Akademik</a>
    <div class="navbar-nav me-auto">
      <a class="nav-link" href="<?= BASE_PATH ?>/dashboard">Dashboard</a>
      <a class="nav-link" href="<?= BASE_PATH ?>/mahasiswa">Mahasiswa</a>
    </div>
    <form action="<?= BASE_PATH ?>/logout" method="POST" class="d-flex">
      <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
    </form>
  </div>
</nav>
