<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

/**
 * Konten contoh supaya tampilan lokal tidak kosong. Hanya dijalankan di environment local.
 * Berita awal diisi oleh BeritaHstSeeder.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Announcement::exists()) {
            return;
        }

        Announcement::create([
            'title' => '[Contoh] Jadwal Pelayanan Selama Libur Akhir Tahun',
            'body' => '<p>Ini adalah pengumuman contoh. Silakan ganti melalui menu Pengumuman di CMS.</p>',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
    }
}
