<?php

namespace App\Models;

use InvalidArgumentException;

class Prodi
{
    private ?int $id = null;
    private string $kode = '';
    private string $nama = '';

    public static function fromArray(array $row): self
    {
        $p = new self();
        if (isset($row['id'])) {
            $p->id = (int) $row['id'];
        }
        if (isset($row['kode'])) {
            $p->setKode($row['kode']);
        }
        if (isset($row['nama'])) {
            $p->setNama($row['nama']);
        }
        return $p;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKode(): string
    {
        return $this->kode;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setKode(string $kode): void
    {
        $kode = strtoupper(trim($kode));
        if ($kode === '') {
            throw new InvalidArgumentException('Kode prodi tidak boleh kosong.');
        }
        $this->kode = $kode;
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);
        if ($nama === '') {
            throw new InvalidArgumentException('Nama prodi tidak boleh kosong.');
        }
        $this->nama = $nama;
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'kode' => $this->kode, 'nama' => $this->nama];
    }
}
