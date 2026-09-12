<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Acara 10 - Model Mahasiswa dipakai bersama MahasiswaRepository
 * (Repository Pattern), bukan lagi mengakses PDO sendiri.
 */
class Mahasiswa
{
    private const STATUS_VALID = ['aktif', 'cuti', 'lulus', 'nonaktif'];

    private ?int $id = null;
    private string $nim = '';
    private string $nama = '';
    private string $email = '';
    private int $prodiId = 0;
    private ?string $prodiNama = null;
    private int $angkatan = 0;
    private string $status = 'aktif';

    public static function fromArray(array $row): self
    {
        $m = new self();
        if (isset($row['id'])) {
            $m->id = (int) $row['id'];
        }
        if (isset($row['nim'])) {
            $m->setNim($row['nim']);
        }
        if (isset($row['nama'])) {
            $m->setNama($row['nama']);
        }
        if (isset($row['email'])) {
            $m->setEmail($row['email']);
        }
        if (isset($row['prodi_id'])) {
            $m->setProdiId((int) $row['prodi_id']);
        }
        if (isset($row['prodi_nama'])) {
            $m->prodiNama = $row['prodi_nama'];
        }
        if (isset($row['angkatan'])) {
            $m->setAngkatan((int) $row['angkatan']);
        }
        if (isset($row['status'])) {
            $m->setStatus($row['status']);
        }
        return $m;
    }

    public function getId(): ?int { return $this->id; }
    public function getNim(): string { return $this->nim; }
    public function getNama(): string { return $this->nama; }
    public function getEmail(): string { return $this->email; }
    public function getProdiId(): int { return $this->prodiId; }
    public function getProdiNama(): ?string { return $this->prodiNama; }
    public function getAngkatan(): int { return $this->angkatan; }
    public function getStatus(): string { return $this->status; }

    public function setNim(string $nim): void
    {
        $nim = trim($nim);
        if ($nim === '') {
            throw new InvalidArgumentException('NIM tidak boleh kosong.');
        }
        $this->nim = $nim;
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);
        if ($nama === '') {
            throw new InvalidArgumentException('Nama tidak boleh kosong.');
        }
        $this->nama = $nama;
    }

    public function setEmail(string $email): void
    {
        $email = trim($email);
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Format email tidak valid.');
        }
        $this->email = $email;
    }

    public function setProdiId(int $prodiId): void
    {
        if ($prodiId <= 0) {
            throw new InvalidArgumentException('Program studi wajib dipilih.');
        }
        $this->prodiId = $prodiId;
    }

    public function setAngkatan(int $angkatan): void
    {
        $tahunSekarang = (int) date('Y');
        if ($angkatan < 2000 || $angkatan > $tahunSekarang) {
            throw new InvalidArgumentException("Angkatan harus antara 2000 dan {$tahunSekarang}.");
        }
        $this->angkatan = $angkatan;
    }

    public function setStatus(string $status): void
    {
        $status = strtolower(trim($status));
        if (!in_array($status, self::STATUS_VALID, true)) {
            throw new InvalidArgumentException('Status tidak valid.');
        }
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'nim'        => $this->nim,
            'nama'       => $this->nama,
            'email'      => $this->email,
            'prodi_id'   => $this->prodiId,
            'prodi_nama' => $this->prodiNama,
            'angkatan'   => $this->angkatan,
            'status'     => $this->status,
        ];
    }
}
