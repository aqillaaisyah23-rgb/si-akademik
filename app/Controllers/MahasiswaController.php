<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Mahasiswa;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use InvalidArgumentException;

/**
 * Acara 10 - Inheritance & Repository Pattern
 *
 * MahasiswaController extends Controller (BaseController) sehingga
 * mewarisi method view(), redirect(), dan flash(). Seluruh akses data
 * dilakukan lewat MahasiswaRepository, tidak ada query SQL di sini.
 */
class MahasiswaController extends Controller
{
    private MahasiswaRepository $repo;
    private ProdiRepository $prodiRepo;

    public function __construct()
    {
        $pdo = Database::getInstance();
        $this->repo = new MahasiswaRepository($pdo);
        $this->prodiRepo = new ProdiRepository($pdo);
    }

    public function index(): void
    {
        $this->view('mahasiswa/index', [
            'title'     => 'Daftar Mahasiswa',
            'mahasiswa' => $this->repo->all(),
            'success'   => $this->flash('success'),
        ]);
    }

    public function create(): void
    {
        $this->view('mahasiswa/create', [
            'title' => 'Tambah Mahasiswa',
            'prodi' => $this->prodiRepo->all(),
            'error' => $this->flash('error'),
        ]);
    }

    public function store(): void
    {
        try {
            $mhs = new Mahasiswa();
            $mhs->setNim($_POST['nim'] ?? '');
            $mhs->setNama($_POST['nama'] ?? '');
            $mhs->setEmail($_POST['email'] ?? '');
            $mhs->setProdiId((int) ($_POST['prodi_id'] ?? 0));
            $mhs->setAngkatan((int) ($_POST['angkatan'] ?? 0));
            $mhs->setStatus($_POST['status'] ?? 'aktif');

            $this->repo->create($mhs);
            $this->flash('success', 'Mahasiswa berhasil ditambahkan.');
            $this->redirect('/mahasiswa');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/mahasiswa/create');
        }
    }

    // TUGAS MANDIRI - lihat detail satu mahasiswa
    public function show(int $id): void
    {
        $mhs = $this->repo->find($id);

        if ($mhs === null) {
            http_response_code(404);
            echo "Mahasiswa tidak ditemukan.";
            return;
        }

        $this->view('mahasiswa/show', [
            'title'     => 'Detail Mahasiswa',
            'mahasiswa' => $mhs,
        ]);
    }

    public function edit(string $id): void
    {
        $mhs = $this->repo->find((int) $id);

        if ($mhs === null) {
            http_response_code(404);
            echo "Mahasiswa tidak ditemukan.";
            return;
        }

        $this->view('mahasiswa/edit', [
            'title'     => 'Edit Mahasiswa',
            'mahasiswa' => $mhs,
            'prodi'     => $this->prodiRepo->all(),
            'error'     => $this->flash('error'),
        ]);
    }

    public function update(string $id): void
    {
        try {
            $mhs = new Mahasiswa();
            $mhs->setNim($_POST['nim'] ?? '');
            $mhs->setNama($_POST['nama'] ?? '');
            $mhs->setEmail($_POST['email'] ?? '');
            $mhs->setProdiId((int) ($_POST['prodi_id'] ?? 0));
            $mhs->setAngkatan((int) ($_POST['angkatan'] ?? 0));
            $mhs->setStatus($_POST['status'] ?? 'aktif');

            $this->repo->update((int) $id, $mhs);
            $this->flash('success', 'Mahasiswa berhasil diperbarui.');
            $this->redirect('/mahasiswa');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/mahasiswa/' . $id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        $this->repo->delete((int) $id);
        $this->flash('success', 'Mahasiswa berhasil dihapus.');
        $this->redirect('/mahasiswa');
    }
}
