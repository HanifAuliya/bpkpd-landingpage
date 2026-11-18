<?php

namespace App\Livewire\Admin;

use App\Models\Service;

class Services extends Resource
{
    public string $title = 'Pelayanan';

    public string $singular = 'Pelayanan';

    public string $description = 'Kartu layanan online di beranda dan halaman layanan.';

    protected function model(): string
    {
        return Service::class;
    }

    protected function columns(): array
    {
        return [
            'icon' => ['label' => 'Ikon', 'type' => 'icon'],
            'title' => ['label' => 'Layanan', 'sub' => 'description'],
            'url' => ['label' => 'Link', 'type' => 'url'],
            'is_active' => ['label' => 'Tampil', 'type' => 'toggle'],
        ];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Nama layanan', 'required' => true],
            'description' => ['label' => 'Keterangan', 'type' => 'textarea', 'rows' => 2],
            'url' => ['label' => 'Link aplikasi', 'type' => 'url'],
            'icon' => ['label' => 'Ikon', 'type' => 'icon'],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
            'is_active' => ['label' => 'Tampilkan', 'type' => 'toggle', 'span' => 1],
        ];
    }
}
