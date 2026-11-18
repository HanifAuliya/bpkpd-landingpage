<?php

namespace App\Livewire\Admin;

use App\Models\Photo;

class Photos extends Resource
{
    public string $title = 'Galeri Foto';

    public string $singular = 'Foto';

    public string $description = 'Dokumentasi kegiatan untuk halaman galeri.';

    protected string $orderBy = 'created_at';

    protected string $orderDirection = 'desc';

    protected int $perPage = 12;

    protected function model(): string
    {
        return Photo::class;
    }

    protected function columns(): array
    {
        return [
            'image' => ['label' => 'Foto', 'type' => 'image'],
            'title' => ['label' => 'Judul', 'sub' => 'taken_at'],
        ];
    }

    protected function fields(): array
    {
        return [
            'image' => ['label' => 'Foto', 'type' => 'image', 'required' => true, 'max' => 6144, 'directory' => 'galeri'],
            'title' => ['label' => 'Judul', 'required' => true],
            'description' => ['label' => 'Keterangan', 'type' => 'textarea', 'rows' => 3],
            'taken_at' => ['label' => 'Tanggal kegiatan', 'type' => 'date'],
        ];
    }
}
