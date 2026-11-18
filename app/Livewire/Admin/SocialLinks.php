<?php

namespace App\Livewire\Admin;

use App\Models\SocialLink;

class SocialLinks extends Resource
{
    public string $title = 'Media Sosial';

    public string $singular = 'Akun media sosial';

    public string $description = 'Tampil di bagian bawah setiap halaman.';

    protected array $searchable = ['platform', 'url'];

    protected function model(): string
    {
        return SocialLink::class;
    }

    protected function columns(): array
    {
        return [
            'platform' => ['label' => 'Platform', 'type' => 'icon-label'],
            'url' => ['label' => 'Link', 'type' => 'url'],
        ];
    }

    protected function fields(): array
    {
        return [
            'platform' => ['label' => 'Platform', 'type' => 'select', 'required' => true, 'options' => [
                'instagram' => 'Instagram', 'facebook' => 'Facebook', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'twitter' => 'X (Twitter)', 'globe' => 'Lainnya',
            ]],
            'url' => ['label' => 'Link profil', 'type' => 'url', 'required' => true],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
        ];
    }
}
