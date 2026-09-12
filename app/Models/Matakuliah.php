<?php

namespace App\Models;

use InvalidArgumentException;

class Matakuliah
{
    private ?int $id = null;
    private string $kode = '';
    private string $nama = '';
    private int $sks = 0;
    private int $prodiId = 0;
    private ?string $prodiNama = null;

    public static function fromArray(array $row): self
    {
        $mk = new self();
        if (isset($row['id'])) {
            $mk->id = (int) $row['id'];
        }
        if (isset($row['kode'])) {
            $mk->setKode($row['kode']);
        }
        if (isset($row['nama'])) {
            $mk->setNama($row['nama']);
        }
        if (isset($row['sks'])) {
            $mk->setSks((int) $row['sks']);
        }
        if (isset($row['prodi_id'])) {
            $mk->setProdiId((int) $row['prodi_id']);
        }
        if (isset($row['prodi_nama'])) {
            $mk->prodiNama = $row['prodi_nama'];
        }
        return $mk;
    }

    public function getId(): ?int { return $this->id; }
    public function getKode(): string { return $this->kode; }
    public function getNama(): string { return $this->nama; }
    public function getSks(): int { return $this->sks; }
    public function getProdiId(): int { return $this->prodiId; }
    public function getProdiNama(): ?string { return $this->prodiNama; }

    public function setKode(string $kode): void
    {
        $kode = strtoupper(trim($kode));
        if ($kode === '') {
            throw new InvalidArgumentException('Kode mata kuliah tidak boleh kosong.');
        }
        $this->kode = $kode;
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);
        if ($nama === '') {
            throw new InvalidArgumentException('Nama mata kuliah tidak boleh kosong.');
        }
        $this->nama = $nama;
    }

    public function setSks(int $sks): void
    {
        if ($sks < 1 || $sks > 6) {
            throw new InvalidArgumentException('SKS harus antara 1 dan 6.');
        }
        $this->sks = $sks;
    }

    public function setProdiId(int $prodiId): void
    {
        if ($prodiId <= 0) {
            throw new InvalidArgumentException('Program studi wajib dipilih.');
        }
        $this->prodiId = $prodiId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id, 'kode' => $this->kode, 'nama' => $this->nama,
            'sks' => $this->sks, 'prodi_id' => $this->prodiId, 'prodi_nama' => $this->prodiNama,
        ];
    }
}
