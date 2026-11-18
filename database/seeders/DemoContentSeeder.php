<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Konten contoh supaya tampilan lokal tidak kosong. Hanya dijalankan di environment local.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::exists()) {
            return;
        }

        $posts = [
            ['[Contoh] Sosialisasi Pajak Daerah kepada Pelaku Usaha di Barabai', 'BPKPD menggelar sosialisasi pajak daerah untuk meningkatkan pemahaman pelaku usaha mengenai kewajiban dan kemudahan pembayaran pajak secara online.'],
            ['[Contoh] Pembayaran PBB-P2 Kini Bisa Dicek Secara Online', 'Masyarakat dapat mengecek data PBB-P2 dan mencetak bukti lunas melalui layanan E-PBB tanpa harus datang ke kantor.'],
            ['[Contoh] Rapat Evaluasi Realisasi Pendapatan Daerah Triwulan III', 'Rapat evaluasi membahas capaian pendapatan daerah dan langkah strategis untuk mencapai target hingga akhir tahun anggaran.'],
        ];
        foreach ($posts as $i => [$title, $excerpt]) {
            Post::create([
                'title' => $title,
                'excerpt' => $excerpt,
                'body' => "<p>{$excerpt}</p><p>Ini adalah konten contoh. Silakan hapus atau ganti melalui menu Berita di CMS.</p>",
                'is_published' => true,
                'published_at' => now()->subDays($i * 4 + 1),
            ]);
        }

        Announcement::create([
            'title' => '[Contoh] Jadwal Pelayanan Selama Libur Akhir Tahun',
            'body' => '<p>Ini adalah pengumuman contoh. Silakan ganti melalui menu Pengumuman di CMS.</p>',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
    }
}
