<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;

class Announcements extends Resource
{
    public string $title = 'Pengumuman';

    public string $singular = 'Pengumuman';

    public string $description = 'Pemberitahuan resmi, bisa dengan lampiran.';

    protected string $orderBy = 'published_at';

    protected string $orderDirection = 'desc';

    public bool $wide = true;

    protected function model(): string
    {
        return Announcement::class;
    }

    protected function columns(): array
    {
        return [
            'title' => ['label' => 'Judul', 'sub' => 'published_at', 'link' => 'pengumuman.show'],
            'attachment' => ['label' => 'Lampiran', 'type' => 'file'],
            'is_published' => ['label' => 'Terbit', 'type' => 'toggle'],
        ];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Judul', 'required' => true],
            'body' => ['label' => 'Isi pengumuman', 'type' => 'richtext'],
            'attachment' => ['label' => 'Lampiran', 'type' => 'file', 'directory' => 'pengumuman'],
            'published_at' => ['label' => 'Tanggal terbit', 'type' => 'datetime', 'span' => 1],
            'is_published' => ['label' => 'Terbitkan', 'type' => 'toggle', 'span' => 1],
        ];
    }
}
