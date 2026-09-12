<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use InvalidArgumentException;

/**
 * Acara 13 - Service Layer
 * Menangani validasi & logika bisnis, supaya Controller tetap tipis.
 */
class MahasiswaService
{
    public function __construct(
        private MahasiswaRepository $repo,
        private ProdiRepository $prodiRepo
    ) {}

    public function create(array $input): array
    {
        $errors = $this->validate($input);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $mhs = $this->buildModel($input);
            $id = $this->repo->create($mhs);
            return ['success' => true, 'id' => $id];
        } catch (InvalidArgumentException $e) {
            return ['success' => false, 'errors' => ['umum' => $e->getMessage()]];
        }
    }

    public function update(int $id, array $input): array
    {
        $errors = $this->validate($input, $id);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $mhs = $this->buildModel($input);
            $this->repo->update($id, $mhs);
            return ['success' => true];
        } catch (InvalidArgumentException $e) {
            return ['success' => false, 'errors' => ['umum' => $e->getMessage()]];
        }
    }

    private function validate(array $input, ?int $excludeId = null): array
    {
        $errors = [];

        if (empty($input['nim'])) {
            $errors['nim'] = 'NIM wajib diisi';
        } elseif ($this->repo->existsByNim($input['nim'], $excludeId)) {
            $errors['nim'] = 'NIM sudah terdaftar';
        }

        if (empty($input['nama'])) {
            $errors['nama'] = 'Nama wajib diisi';
        }

        if (empty($input['prodi_id']) || (int) $input['prodi_id'] <= 0) {
            $errors['prodi_id'] = 'Program studi wajib dipilih';
        }

        return $errors;
    }

    private function buildModel(array $input): Mahasiswa
    {
        $mhs = new Mahasiswa();
        $mhs->setNim($input['nim'] ?? '');
        $mhs->setNama($input['nama'] ?? '');
        $mhs->setEmail($input['email'] ?? '');
        $mhs->setProdiId((int) ($input['prodi_id'] ?? 0));
        $mhs->setAngkatan((int) ($input['angkatan'] ?? 0));
        $mhs->setStatus($input['status'] ?? 'aktif');
        return $mhs;
    }
}