<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Prodi;
use App\Repositories\ProdiRepository;
use InvalidArgumentException;

class ProdiController extends Controller
{
    private ProdiRepository $repo;

    public function __construct()
    {
        $this->repo = new ProdiRepository(Database::getInstance());
    }

    public function index(): void
    {
        $this->view('prodi/index', [
            'title'   => 'Program Studi',
            'prodi'   => $this->repo->all(),
            'success' => $this->flash('success'),
        ]);
    }

    public function create(): void
    {
        $this->view('prodi/create', [
            'title' => 'Tambah Prodi',
            'error' => $this->flash('error'),
        ]);
    }

    public function store(): void
    {
        try {
            $prodi = new Prodi();
            $prodi->setKode($_POST['kode'] ?? '');
            $prodi->setNama($_POST['nama'] ?? '');

            $this->repo->create($prodi);
            $this->flash('success', 'Prodi berhasil ditambahkan.');
            $this->redirect('/prodi');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/prodi/create');
        }
    }

    public function edit(string $id): void
    {
        $prodi = $this->repo->find((int) $id);

        if ($prodi === null) {
            http_response_code(404);
            echo "Prodi tidak ditemukan.";
            return;
        }

        $this->view('prodi/edit', [
            'title' => 'Edit Prodi',
            'prodi' => $prodi,
            'error' => $this->flash('error'),
        ]);
    }

    public function update(string $id): void
    {
        try {
            $prodi = new Prodi();
            $prodi->setKode($_POST['kode'] ?? '');
            $prodi->setNama($_POST['nama'] ?? '');

            $this->repo->update((int) $id, $prodi);
            $this->flash('success', 'Prodi berhasil diperbarui.');
            $this->redirect('/prodi');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/prodi/' . $id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        $this->repo->delete((int) $id);
        $this->flash('success', 'Prodi berhasil dihapus.');
        $this->redirect('/prodi');
    }
}
