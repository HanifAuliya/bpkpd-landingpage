<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Posts extends Resource
{
    public string $title = 'Berita';

    public string $singular = 'Berita';

    public string $description = 'Tulis dan terbitkan berita kegiatan.';

    protected string $orderBy = 'published_at';

    protected string $orderDirection = 'desc';

    public bool $wide = true;

    protected function model(): string
    {
        return Post::class;
    }

    protected function columns(): array
    {
        return [
            'image' => ['label' => 'Gambar', 'type' => 'image'],
            'title' => ['label' => 'Judul', 'sub' => 'published_at', 'link' => 'berita.show'],
            'views' => ['label' => 'Dibaca', 'type' => 'number'],
            'is_published' => ['label' => 'Terbit', 'type' => 'toggle'],
        ];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Judul', 'required' => true],
            'image' => ['label' => 'Gambar utama', 'type' => 'image', 'directory' => 'berita'],
            'excerpt' => ['label' => 'Ringkasan', 'type' => 'textarea', 'rows' => 2, 'hint' => 'Opsional. Kosongkan untuk diambil dari isi berita.'],
            'body' => ['label' => 'Isi berita', 'type' => 'richtext', 'required' => true],
            'published_at' => ['label' => 'Tanggal terbit', 'type' => 'datetime', 'span' => 1],
            'is_published' => ['label' => 'Terbitkan', 'type' => 'toggle', 'span' => 1],
        ];
    }

    protected function beforeSave(array $data, ?Model $record): array
    {
        if (! $record) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
