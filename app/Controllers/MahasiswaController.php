<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use App\Services\MahasiswaService;

class MahasiswaController extends Controller
{
    private MahasiswaRepository $repo;
    private ProdiRepository $prodiRepo;
    private MahasiswaService $service;

    public function __construct()
    {
        $pdo = Database::getInstance();
        $this->repo = new MahasiswaRepository($pdo);
        $this->prodiRepo = new ProdiRepository($pdo);
        $this->service = new MahasiswaService($this->repo, $this->prodiRepo);
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
        $result = $this->service->create($_POST);

        if ($result['success']) {
            $this->flash('success', 'Mahasiswa berhasil ditambahkan.');
            $this->redirect('/mahasiswa');
            return;
        }

        $this->flash('error', implode(', ', $result['errors']));
        $this->redirect('/mahasiswa/create');
    }

    public function update(string $id): void
    {
        $result = $this->service->update((int) $id, $_POST);

        if ($result['success']) {
            $this->flash('success', 'Mahasiswa berhasil diperbarui.');
            $this->redirect('/mahasiswa');
            return;
        }

        $this->flash('error', implode(', ', $result['errors']));
        $this->redirect('/mahasiswa/' . $id . '/edit');
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


    public function destroy(string $id): void
    {
        $this->repo->delete((int) $id);
        $this->flash('success', 'Mahasiswa berhasil dihapus.');
        $this->redirect('/mahasiswa');
    }
}
