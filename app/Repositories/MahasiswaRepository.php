<?php

namespace App\Repositories;

use App\Models\Mahasiswa;
use PDO;

/**
 * Acara 8 - PDO, Prepared Statement, Relasi, CRUD Lengkap
 * Acara 9 - menerima PDO lewat constructor (Dependency Injection),
 *           bukan membuat koneksi sendiri.
 */
class MahasiswaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Ambil semua mahasiswa berikut nama prodi-nya (JOIN). */
    public function all(): array
    {
        $stmt = $this->pdo->query(
            "SELECT m.*, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             ORDER BY m.nim"
        );

        return array_map(fn($row) => Mahasiswa::fromArray($row), $stmt->fetchAll());
    }

    /** Tugas mandiri Acara 8: search berdasarkan nama atau NIM dengan LIKE. */
    public function search(string $keyword): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.nama LIKE :kw OR m.nim LIKE :kw
             ORDER BY m.nim"
        );
        $stmt->execute(['kw' => '%' . $keyword . '%']);

        return array_map(fn($row) => Mahasiswa::fromArray($row), $stmt->fetchAll());
    }

    public function find(int $id): ?Mahasiswa
    {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.id = :id"
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? Mahasiswa::fromArray($row) : null;
    }

    public function create(Mahasiswa $mahasiswa): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)"
        );
        $stmt->execute([
            'nim'      => $mahasiswa->getNim(),
            'nama'     => $mahasiswa->getNama(),
            'email'    => $mahasiswa->getEmail(),
            'prodi_id' => $mahasiswa->getProdiId(),
            'angkatan' => $mahasiswa->getAngkatan(),
            'status'   => $mahasiswa->getStatus(),
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, Mahasiswa $mahasiswa): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id"
        );
        $stmt->execute([
            'nim'      => $mahasiswa->getNim(),
            'nama'     => $mahasiswa->getNama(),
            'email'    => $mahasiswa->getEmail(),
            'prodi_id' => $mahasiswa->getProdiId(),
            'angkatan' => $mahasiswa->getAngkatan(),
            'status'   => $mahasiswa->getStatus(),
            'id'       => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
