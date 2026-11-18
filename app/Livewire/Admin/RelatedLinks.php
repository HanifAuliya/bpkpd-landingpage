<?php

namespace App\Livewire\Admin;

use App\Models\RelatedLink;

class RelatedLinks extends Resource
{
    public string $title = 'Link Terkait';

    public string $singular = 'Link';

    public string $description = 'Tautan ke instansi lain, tampil berjalan di beranda.';

    protected array $searchable = ['name', 'url'];

    protected function model(): string
    {
        return RelatedLink::class;
    }

    protected function columns(): array
    {
        return [
            'name' => ['label' => 'Nama'],
            'url' => ['label' => 'Link', 'type' => 'url'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama', 'required' => true],
            'url' => ['label' => 'Link', 'type' => 'url', 'required' => true],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
        ];
    }
}
