<?php

namespace App\Livewire\Admin;

use App\Models\ServiceType;

class ServiceTypes extends Resource
{
    public string $title = 'Jenis Pelayanan';

    public string $singular = 'Jenis pelayanan';

    public string $description = 'Standar pelayanan: persyaratan, waktu, dan biaya.';

    protected array $searchable = ['name', 'notes'];

    protected function model(): string
    {
        return ServiceType::class;
    }

    protected function columns(): array
    {
        return [
            'name' => ['label' => 'Jenis layanan', 'sub' => 'notes'],
            'duration' => ['label' => 'Jangka waktu'],
            'cost' => ['label' => 'Biaya'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Jenis layanan', 'required' => true],
            'requirements' => ['label' => 'Persyaratan', 'type' => 'textarea', 'rows' => 4, 'hint' => 'Satu persyaratan per baris.'],
            'url' => ['label' => 'Link', 'type' => 'url'],
            'duration' => ['label' => 'Jangka waktu', 'span' => 1],
            'cost' => ['label' => 'Biaya', 'span' => 1],
            'notes' => ['label' => 'Keterangan', 'type' => 'textarea', 'rows' => 2],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
        ];
    }
}
