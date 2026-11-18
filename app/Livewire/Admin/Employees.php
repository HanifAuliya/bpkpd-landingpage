<?php

namespace App\Livewire\Admin;

use App\Models\Employee;

class Employees extends Resource
{
    public string $title = 'Data Pegawai';

    public string $singular = 'Pegawai';

    public string $description = 'Urutan teratas tampil di bagan struktur organisasi.';

    protected array $searchable = ['name', 'position', 'nip'];

    protected function model(): string
    {
        return Employee::class;
    }

    protected function columns(): array
    {
        return [
            'photo' => ['label' => 'Foto', 'type' => 'avatar'],
            'name' => ['label' => 'Nama', 'sub' => 'position'],
            'nip' => ['label' => 'NIP'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama lengkap & gelar', 'required' => true],
            'position' => ['label' => 'Jabatan', 'required' => true],
            'nip' => ['label' => 'NIP', 'span' => 1],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
            'photo' => ['label' => 'Foto', 'type' => 'image', 'hint' => 'Rasio 4:5, latar polos.', 'directory' => 'pegawai'],
        ];
    }
}
