<?php

namespace App\Livewire\Admin;

use App\Models\Document;

class Documents extends Resource
{
    public string $title = 'Dokumen';

    public string $singular = 'Dokumen';

    public string $description = 'Dokumen publik yang bisa diunduh masyarakat.';

    protected array $searchable = ['name', 'type'];

    protected string $orderBy = 'created_at';

    protected string $orderDirection = 'desc';

    protected function model(): string
    {
        return Document::class;
    }

    protected function columns(): array
    {
        return [
            'name' => ['label' => 'Nama dokumen', 'sub' => 'type'],
            'year' => ['label' => 'Tahun'],
            'downloads' => ['label' => 'Unduhan', 'type' => 'number'],
            'file' => ['label' => 'File', 'type' => 'file'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama dokumen', 'required' => true],
            'type' => ['label' => 'Jenis dokumen', 'span' => 1, 'hint' => 'Contoh: Renstra, LKjIP, Perda'],
            'year' => ['label' => 'Tahun terbit', 'type' => 'number', 'span' => 1, 'default' => date('Y')],
            'file' => ['label' => 'File', 'type' => 'file', 'required' => true, 'directory' => 'dokumen'],
        ];
    }
}
