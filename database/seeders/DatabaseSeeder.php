<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\RelatedLink;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data awal diambil dari situs lama bpkpd.hstkab.go.id (November 2026).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@bpkpd.test')],
            ['name' => 'Administrator', 'password' => env('ADMIN_PASSWORD', 'password')],
        );

        Setting::put([
            'nama_dinas' => 'Badan Pengelolaan Keuangan dan Pendapatan Daerah',
            'nama_singkat' => 'BPKPD',
            'daerah' => 'Kabupaten Hulu Sungai Tengah',
            'tagline' => 'Mengelola keuangan dan pendapatan daerah secara kredibel, transparan, dan melayani.',
            'deskripsi' => 'Badan Pengelolaan Keuangan dan Pendapatan Daerah (BPKPD) adalah unsur penunjang penyelenggaraan pemerintahan daerah yang memiliki tugas pokok membantu kepala daerah dalam melaksanakan fungsi penunjang keuangan dan pendapatan daerah. BPKPD bertanggung jawab atas pengelolaan anggaran, akuntansi, pelaporan keuangan, pengelolaan barang milik daerah serta pemungutan pajak dan retribusi daerah sesuai dengan kebijakan dan peraturan yang berlaku.',
            'visi' => 'Menciptakan pengelolaan pajak dan retribusi daerah yang kredibel dan transparan',
            'misi' => "Peningkatan dan pengembangan potensi Pajak dan Retribusi daerah\nPeningkatan sumber daya manusia aparatur\nPemanfaatan teknologi untuk mendukung tata kelola pendapatan dan layanan publik",
            'tugas' => 'Sebagai unsur pelaksana otonomi daerah di bidang pengelolaan pendapatan, BPKPD Kabupaten Hulu Sungai Tengah memiliki tugas pokok melaksanakan urusan pemerintahan daerah berdasarkan asas otonomi dan tugas pembantuan di bidang pengelolaan pendapatan pajak dan retribusi daerah.',
            'fungsi' => "Perumusan kebijakan teknis di bidang pengelolaan pendapatan pajak dan retribusi sesuai dengan kebijakan umum yang ditetapkan oleh Bupati\nPenyelenggaraan urusan pemerintahan dan pelayanan umum di bidang pengelolaan pendapatan pajak dan retribusi daerah\nPembinaan, koordinasi, pengendalian dan fasilitasi kegiatan pajak dan pendapatan lain-lain yang sah\nPembinaan, koordinasi, pengendalian dan fasilitasi kegiatan retribusi daerah\nPembinaan, koordinasi, pengendalian dan fasilitasi kegiatan Pajak Bumi dan Bangunan\nPembinaan, koordinasi, pengendalian dan fasilitasi kegiatan pembinaan, pengembangan dan pengendalian\nPembinaan, koordinasi, pengendalian dan fasilitasi kegiatan Unit Pelaksana Teknis\nPengelolaan kegiatan kesekretariatan",
            'alamat' => 'Jl. Perwira, Barabai Selatan, Kec. Barabai, Kabupaten Hulu Sungai Tengah, Kalimantan Selatan 71315',
            'email' => 'bpkpd@hstkab.go.id',
            'telepon' => '',
            'jam_layanan' => "Senin - Kamis: 08.00 - 16.00 WITA\nJumat: 08.00 - 11.00 WITA",
            'maps_query' => 'BPKPD Hulu Sungai Tengah, Jl. Perwira, Barabai',
            'kepala_nama' => 'Khairil, S.IP, MM.',
            'kepala_jabatan' => 'Kepala Badan Pengelolaan Keuangan dan Pendapatan Daerah',
            'sambutan' => 'Selamat datang di website resmi BPKPD Kabupaten Hulu Sungai Tengah. Website ini kami hadirkan sebagai sarana informasi dan layanan publik di bidang keuangan, pajak, dan retribusi daerah. Semoga bermanfaat bagi seluruh masyarakat.',
        ]);

        Slider::truncate();
        Slider::insert([
            ['title' => 'Selamat Datang', 'subtitle' => 'Website Resmi Badan Pengelolaan Keuangan dan Pendapatan Daerah', 'button_text' => 'Kenali Kami', 'button_url' => '/profil', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Bayar Pajak Daerah Lebih Mudah', 'subtitle' => 'Layanan pajak daerah, BPHTB, dan PBB-P2 secara online untuk masyarakat Hulu Sungai Tengah', 'button_text' => 'Lihat Layanan', 'button_url' => '/layanan', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Service::truncate();
        foreach ([
            ['SIPANDA', 'Pelayanan Pajak Daerah Non PBB-P2 dan BPHTB', 'receipt', 'https://sipanda.hstkab.go.id/login'],
            ['SIMBPHTB', 'Pelayanan Bea Perolehan Hak atas Tanah dan Bangunan', 'home', 'https://bphtb.hstkab.go.id/bphtb/'],
            ['E-PBB (KSWP)', 'Cek data PBB-P2 dan cetak bukti lunas PBB-P2', 'search', 'http://epbb.hstkab.go.id/epbb/'],
            ['SIMBADA', 'Sistem Informasi Manajemen Barang Daerah milik Pemerintah Kabupaten Hulu Sungai Tengah', 'boxes', 'https://simbada.hstkab.go.id/'],
            ['SiPPER HST', 'Sistem Informasi Pencatatan Persediaan', 'clipboard', 'https://sipper.hstkab.go.id/'],
        ] as $i => [$title, $desc, $icon, $url]) {
            Service::create(['title' => $title, 'description' => $desc, 'icon' => $icon, 'url' => $url, 'sort_order' => $i + 1]);
        }

        ServiceType::truncate();
        foreach ([
            ['SiPanda', "Scan KTP / NIB (Nomor Induk Berusaha)\nEmail\nNomor WhatsApp", 'https://sipanda.hstkab.go.id/login', 'Pendaftaran NPWPD (Nomor Pokok Wajib Pajak Daerah)'],
            ['SIMBPHTB', null, 'https://bphtb.hstkab.go.id/bphtb/', 'Pelayanan BPHTB'],
            ['SIMPBB', null, 'http://epbb.hstkab.go.id/sismiop/', 'Pelayanan PBB-P2'],
            ['E-PBB (KSWP)', null, 'http://epbb.hstkab.go.id/epbb/', 'Cek data PBB-P2 dan cetak tanda lunas PBB-P2'],
        ] as $i => [$name, $req, $url, $notes]) {
            ServiceType::create(['name' => $name, 'requirements' => $req, 'url' => $url, 'duration' => '1 Hari Kerja', 'cost' => 'Gratis', 'notes' => $notes, 'sort_order' => $i + 1]);
        }

        SocialLink::truncate();
        SocialLink::create(['platform' => 'instagram', 'url' => 'https://www.instagram.com/bpkpdhst', 'sort_order' => 1]);
        SocialLink::create(['platform' => 'tiktok', 'url' => 'https://www.tiktok.com/@bpkpdhst', 'sort_order' => 2]);

        RelatedLink::truncate();
        foreach ([
            ['Portal Kabupaten HST', 'https://www.hulusungaitengahkab.go.id/'],
            ['MC Hulu Sungai Tengah', 'https://mediacenter.hstkab.go.id/'],
            ['Diskominfo HST', 'https://diskominfo.hstkab.go.id/'],
            ['Kementerian Komdigi', 'https://www.komdigi.go.id/'],
            ['MC Kalsel Prov', 'https://diskominfomc.kalselprov.go.id/'],
            ['Diskominfo Kalsel Prov', 'https://diskominfo.kalselprov.go.id/'],
            ['LAPOR!', 'https://www.lapor.go.id/'],
        ] as $i => [$name, $url]) {
            RelatedLink::create(['name' => $name, 'url' => $url, 'sort_order' => $i + 1]);
        }

        Employee::truncate();
        foreach ([
            ['KHAIRIL, S.IP, MM.', 'Kepala Badan Pengelolaan Keuangan dan Pendapatan Daerah'],
            ['AHMAD RIZQAN, ST, MS', 'Sekretaris'],
            ['NANANG JAMI, SP', 'Kepala Bidang Pajak dan Retribusi Daerah'],
            ['ABDI GUNAWAN, ST', 'Kepala Bidang Pembinaan, Pengembangan, dan Pengendalian Pajak dan Retribusi Daerah'],
            ['ASMILAWATI, S.Sos', 'Kasubbag Umum dan Kepegawaian'],
            ['RUSNIAH, SE', 'Kepala Sub Bidang Pajak Daerah'],
            ['RUDY FIRMANSYAH, SP', 'Kepala Sub Bidang Retribusi Daerah'],
            ['USWATUN HASANAH, S.Pd', 'Kepala Sub Bidang Penagihan dan Pelaporan PBB'],
            ['ERNAWATI, SE', 'Kepala Sub Bidang Penetapan PBB dan BPHTB'],
            ['RINI YULITA, SE', 'Kepala Sub Bidang Pengembangan Pajak dan Retribusi Daerah'],
            ['ALPIYANNOOR, S.Pd', 'Kepala Sub Bidang Pengendalian dan Pengaduan Pajak dan Retribusi Daerah'],
            ['FAHRINA RUSMINI', 'Pengadministrasi Kepegawaian'],
            ['IKA NOVIANA, S.Kom', 'Analis Sumber Daya Manusia Aparatur Ahli Pertama'],
            ['SYAMMI FADILLAH, A.Md', 'Arsiparis Terampil'],
            ['ALFIAN NOR, S.Kom', 'Pranata Komputer Ahli Pertama'],
            ['RISNA MAHRIANI, A.Md', 'Verifikator Keuangan'],
            ["RAUDATUN NI'MAH, S.AK", 'Penyusun Program Anggaran dan Pelaporan'],
            ['HUSNA, S.Hut', 'Analis Keuangan Pusat dan Daerah Ahli Pertama'],
            ['MIFTAHUL JANNAH, S.E', 'Perencana Ahli Pertama'],
            ['NANANG PRIBADI, SE', 'Analis Pajak dan Retribusi'],
            ['M. MAHDI', 'Pengadministrasi Perkantoran'],
        ] as $i => [$name, $position]) {
            Employee::create(['name' => $name, 'position' => $position, 'sort_order' => $i + 1]);
        }

        $this->call(BeritaHstSeeder::class);

        if (app()->environment('local')) {
            $this->call(DemoContentSeeder::class);
        }
    }
}
