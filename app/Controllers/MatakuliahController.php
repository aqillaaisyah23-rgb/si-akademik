<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Matakuliah;
use App\Repositories\MatakuliahRepository;
use App\Repositories\ProdiRepository;
use InvalidArgumentException;

class MatakuliahController extends Controller
{
    private MatakuliahRepository $repo;
    private ProdiRepository $prodiRepo;

    public function __construct()
    {
        $pdo = Database::getInstance();
        $this->repo = new MatakuliahRepository($pdo);
        $this->prodiRepo = new ProdiRepository($pdo);
    }

    public function index(): void
    {
        $this->view('matakuliah/index', [
            'title'      => 'Mata Kuliah',
            'matakuliah' => $this->repo->all(),
            'success'    => $this->flash('success'),
        ]);
    }

    public function create(): void
    {
        $this->view('matakuliah/create', [
            'title' => 'Tambah Mata Kuliah',
            'prodi' => $this->prodiRepo->all(),
            'error' => $this->flash('error'),
        ]);
    }

    public function store(): void
    {
        try {
            $mk = new Matakuliah();
            $mk->setKode($_POST['kode'] ?? '');
            $mk->setNama($_POST['nama'] ?? '');
            $mk->setSks((int) ($_POST['sks'] ?? 0));
            $mk->setProdiId((int) ($_POST['prodi_id'] ?? 0));

            $this->repo->create($mk);
            $this->flash('success', 'Mata kuliah berhasil ditambahkan.');
            $this->redirect('/matakuliah');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/matakuliah/create');
        }
    }

    public function edit(string $id): void
    {
        $mk = $this->repo->find((int) $id);

        if ($mk === null) {
            http_response_code(404);
            echo "Mata kuliah tidak ditemukan.";
            return;
        }

        $this->view('matakuliah/edit', [
            'title'      => 'Edit Mata Kuliah',
            'matakuliah' => $mk,
            'prodi'      => $this->prodiRepo->all(),
            'error'      => $this->flash('error'),
        ]);
    }

    public function update(string $id): void
    {
        try {
            $mk = new Matakuliah();
            $mk->setKode($_POST['kode'] ?? '');
            $mk->setNama($_POST['nama'] ?? '');
            $mk->setSks((int) ($_POST['sks'] ?? 0));
            $mk->setProdiId((int) ($_POST['prodi_id'] ?? 0));

            $this->repo->update((int) $id, $mk);
            $this->flash('success', 'Mata kuliah berhasil diperbarui.');
            $this->redirect('/matakuliah');
        } catch (InvalidArgumentException $e) {
            $this->flash('error', $e->getMessage());
            $this->redirect('/matakuliah/' . $id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        $this->repo->delete((int) $id);
        $this->flash('success', 'Mata kuliah berhasil dihapus.');
        $this->redirect('/matakuliah');
    }
}
