<?php

namespace App\Livewire\Admin;

use App\Models\Slider;

class Sliders extends Resource
{
    public string $title = 'Carousel';

    public string $singular = 'Slide';

    public string $description = 'Slide besar di bagian atas beranda.';

    protected function model(): string
    {
        return Slider::class;
    }

    protected function columns(): array
    {
        return [
            'image' => ['label' => 'Gambar', 'type' => 'image'],
            'title' => ['label' => 'Judul', 'sub' => 'subtitle'],
            'is_active' => ['label' => 'Tampil', 'type' => 'toggle'],
        ];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Judul besar', 'required' => true],
            'subtitle' => ['label' => 'Judul kecil'],
            'image' => ['label' => 'Gambar latar', 'type' => 'image', 'hint' => 'Disarankan 1920x1080 px. Kosongkan untuk latar animasi.', 'directory' => 'sliders'],
            'button_text' => ['label' => 'Teks tombol', 'span' => 1],
            'button_url' => ['label' => 'Link tombol', 'span' => 1, 'hint' => 'Contoh: /layanan'],
            'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'span' => 1],
            'is_active' => ['label' => 'Tampilkan', 'type' => 'toggle', 'span' => 1],
        ];
    }
}
