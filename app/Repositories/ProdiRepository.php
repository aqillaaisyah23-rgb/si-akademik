<?php

namespace App\Repositories;

use App\Models\Prodi;
use PDO;

class ProdiRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM prodi ORDER BY nama");
        return array_map(fn($row) => Prodi::fromArray($row), $stmt->fetchAll());
    }

    public function find(int $id): ?Prodi
    {
        $stmt = $this->pdo->prepare("SELECT * FROM prodi WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Prodi::fromArray($row) : null;
    }

    public function create(Prodi $prodi): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO prodi (kode, nama) VALUES (:kode, :nama)");
        $stmt->execute(['kode' => $prodi->getKode(), 'nama' => $prodi->getNama()]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, Prodi $prodi): void
    {
        $stmt = $this->pdo->prepare("UPDATE prodi SET kode = :kode, nama = :nama WHERE id = :id");
        $stmt->execute(['kode' => $prodi->getKode(), 'nama' => $prodi->getNama(), 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM prodi WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
