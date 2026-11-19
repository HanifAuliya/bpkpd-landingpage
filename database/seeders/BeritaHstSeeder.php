<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Berita awal: ringkasan pemberitaan media tentang BPKPD dan keuangan daerah HST (Juni–Oktober 2026).
 * Setiap berita mencantumkan tautan ke sumber aslinya. Dapat diganti atau dihapus lewat menu Berita di CMS.
 */
class BeritaHstSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->items() as $item) {
            $body = $item['body'].$this->source($item['sources'], $item['date']);

            $post = Post::firstOrCreate(['title' => $item['title']], [
                'excerpt' => $item['excerpt'],
                'body' => $body,
                'image' => $this->storeImage($item['image']),
                'is_published' => true,
                'published_at' => $item['date'].' 09:00:00',
            ]);

            // Berita yang sudah ada tanpa gambar (dari versi seeder sebelumnya) dilengkapi gambarnya.
            if (blank($post->image)) {
                $post->update([
                    'image' => $this->storeImage($item['image']),
                    'body' => str_contains($post->body, 'Disarikan dari pemberitaan') ? $body : $post->body,
                ]);
            }
        }
    }

    /**
     * Salin foto berita dari database/seeders/berita ke disk publik (folder yang sama dengan unggahan CMS).
     */
    private function storeImage(string $file): string
    {
        $path = 'berita/'.$file;

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents(database_path('seeders/berita/'.$file)));
        }

        return $path;
    }

    /**
     * @param  array<int, array{0: string, 1: string}>  $sources
     */
    private function source(array $sources, string $date): string
    {
        $links = collect($sources)
            ->map(fn (array $source) => '<a href="'.e($source[1]).'" target="_blank" rel="noopener">'.e($source[0]).'</a>')
            ->join(' dan ');

        return '<p class="sumber">Disarikan dari pemberitaan '.$links.' ('.Carbon::parse($date)->translatedFormat('d F Y').'). Foto: '.e($sources[0][0]).'.</p>';
    }

    /**
     * @return array<int, array{title: string, date: string, image: string, excerpt: string, body: string, sources: array<int, array{0: string, 1: string}>}>
     */
    private function items(): array
    {
        return [
            [
                'title' => 'Usaha Makan dan Minum Beromzet di Bawah Rp7,5 Juta per Bulan Tidak Dikenai PBJT',
                'date' => '2026-10-14',
                'image' => 'pbjt.jpg',
                'excerpt' => 'Bupati HST Samsul Rizal memastikan pajak barang dan jasa tertentu (PBJT) atas makanan dan minuman tidak dikenakan kepada usaha beromzet di bawah Rp7,5 juta per bulan.',
                'body' => '<p>Bupati Hulu Sungai Tengah Samsul Rizal memastikan kebijakan pajak daerah tetap melindungi keberlangsungan usaha masyarakat. Hal itu disampaikan saat menjawab pemandangan umum fraksi-fraksi DPRD HST atas tiga rancangan peraturan daerah, salah satunya perubahan Perda Pajak Daerah dan Retribusi Daerah.</p>'
                    .'<p>Bupati menegaskan bahwa pajak barang dan jasa tertentu (PBJT) atas makanan dan/atau minuman <strong>tidak dikenakan kepada usaha dengan omzet di bawah Rp7.500.000 per bulan</strong>. Ketentuan ini dimaksudkan untuk melindungi pelaku UMKM, sekaligus menjawab kekhawatiran Fraksi Golkar soal beban masyarakat dan roda ekonomi.</p>'
                    .'<p>Pemerintah daerah juga menyambut usulan Fraksi Demokrat agar tarif retribusi jasa umum, seperti persampahan, pelayanan pasar, dan kesehatan, dikaitkan dengan standar pelayanan dan kemampuan masyarakat. Penguatan pembayaran digital melalui E-Tax dan E-Retribusi, sejalan dengan masukan Fraksi PKS, akan dibahas lebih lanjut.</p>'
                    .'<p>Menanggapi Fraksi PAN, target pendapatan asli daerah (PAD) akan disesuaikan dengan potensi riil. Kepada Fraksi Nasdem, Bupati menyampaikan bahwa penyesuaian tarif harus adil, proporsional, dan transparan. Setelah penyampaian jawaban tersebut, DPRD HST membentuk panitia khusus untuk melanjutkan pembahasan.</p>',
                'sources' => [['ANTARA Kalsel', 'https://kalsel.antaranews.com/berita/539153/bupati-hst-pastikan-kebijakan-pajak-lindungi-keberlangsungan-usaha-masyarakat']],
            ],
            [
                'title' => 'Pemkab HST Ajukan Perubahan Perda Pajak Daerah dan Retribusi Daerah ke DPRD',
                'date' => '2026-10-12',
                'image' => 'raperda.jpg',
                'excerpt' => 'Perubahan kedua atas Perda HST Nomor 1 Tahun 2024 menyesuaikan tarif PBJT makanan dan minuman serta tarif retribusi jasa umum dan jasa usaha.',
                'body' => '<p>Pemerintah Kabupaten Hulu Sungai Tengah mengajukan tiga rancangan peraturan daerah (Raperda) dalam rapat paripurna DPRD HST di Lantai II Gedung DPRD, Barabai. Rapat dipimpin Ketua DPRD HST H. Pahrijani dan Raperda disampaikan langsung oleh Bupati Samsul Rizal.</p>'
                    .'<p>Raperda pertama adalah <strong>perubahan kedua atas Peraturan Daerah Kabupaten HST Nomor 1 Tahun 2024 tentang Pajak Daerah dan Retribusi Daerah</strong>. Perubahan ini menyesuaikan tarif PBJT atas makanan dan/atau minuman, tarif retribusi jasa umum, serta tarif retribusi jasa usaha.</p>'
                    .'<p>Menurut Bupati, penyesuaian dilakukan untuk mengevaluasi efektivitas pemungutan, mengoptimalkan PAD, dan menyelaraskan aturan daerah dengan peraturan yang lebih tinggi dengan tetap mengedepankan prinsip keadilan. Aturan baru diharapkan tidak membebani masyarakat maupun pelaku usaha lokal secara berlebihan.</p>'
                    .'<p>Dua Raperda lainnya mengatur kepemudaan dan keolahragaan, serta penyelenggaraan perumahan dan kawasan permukiman. Ketiganya akan dibahas bersama DPRD HST.</p>',
                'sources' => [['ANTARA Kalsel', 'https://kalsel.antaranews.com/berita/538717/pemkab-hst-ajukan-tiga-raperda-terkait-pajak-daerah-hingga-perumahan']],
            ],
            [
                'title' => 'BPKPD HST dan UPPD Barabai Bahas Cost Sharing Opsen PKB dan BBNKB Tahun Anggaran 2027',
                'date' => '2026-09-24',
                'image' => 'cost-sharing.jpg',
                'excerpt' => 'Rapat koordinasi membahas rencana pendanaan bersama untuk program pelayanan Samsat tahun 2027, termasuk dukungan sarana dan prasarana.',
                'body' => '<p>BPKPD Kabupaten Hulu Sungai Tengah bersama Unit Pelayanan Pendapatan Daerah (UPPD) Barabai menggelar rapat koordinasi pembahasan <em>cost sharing</em> opsen Pajak Kendaraan Bermotor (PKB) dan Bea Balik Nama Kendaraan Bermotor (BBNKB) untuk Tahun Anggaran 2027.</p>'
                    .'<p>Rapat ini merupakan bagian dari sinergi Pemerintah Provinsi Kalimantan Selatan, melalui UPPD Barabai, dengan Pemerintah Kabupaten HST dalam menyusun rencana pendanaan bersama bagi program pelayanan tahun 2027.</p>'
                    .'<p>Pembahasan mencakup penyelarasan kebutuhan anggaran, dukungan sarana dan prasarana pelayanan, serta penguatan program layanan Samsat. Kedua instansi berkomitmen menggunakan anggaran secara efektif, efisien, dan akuntabel, serta mendorong optimalisasi pendapatan asli daerah dari sektor PKB.</p>'
                    .'<p>Kepala UPPD Barabai, Pengayom Bayu Ajie, menilai kolaborasi ini memperkuat inovasi pelayanan Samsat, baik layanan di kantor maupun layanan jemput bola kepada masyarakat.</p>',
                'sources' => [['UPPD Barabai', 'https://uppdbarabai.com/uppd-barabai-dan-bpkpd-hst-pererat-sinergi-melalui-rapat-cost-sharing-opsen-pkb-dan-bbnkb-ta-2027/']],
            ],
            [
                'title' => 'BPKPD HST Ikut Sosialisasikan Program Pemutihan PKB dan BBNKB di Tugu Burung Anggang',
                'date' => '2026-09-11',
                'image' => 'pemutihan.jpg',
                'excerpt' => 'Bersama UPPD Barabai, Jasa Raharja, dan Satlantas Polres HST, petugas membagikan brosur dan informasi pemutihan pajak kendaraan kepada pengguna jalan.',
                'body' => '<p>BPKPD Kabupaten Hulu Sungai Tengah bersama UPPD Barabai, PT Jasa Raharja, dan anggota Satlantas Polres HST menggelar sosialisasi Program Pemutihan PKB dan BBNKB serta layanan unggulan Samsat Keliling di kawasan Tugu Simpang Tiga Burung Anggang, Barabai.</p>'
                    .'<p>Program pemutihan merupakan kebijakan Pemerintah Provinsi Kalimantan Selatan. Sosialisasi bertujuan meningkatkan kesadaran masyarakat sekaligus mengoptimalkan pendapatan asli daerah dari pajak kendaraan bermotor.</p>'
                    .'<p>Petugas membagikan brosur dan memberikan informasi langsung kepada pengguna jalan tentang manfaat program pemutihan, tata cara pembayaran pajak, dan layanan Samsat Keliling yang menjangkau wilayah HST. Masyarakat diajak memanfaatkan kemudahan ini untuk melunasi tunggakan PKB sesuai ketentuan.</p>'
                    .'<p>Jasa Raharja dan Satlantas turut memberikan edukasi mengenai tertib administrasi kendaraan dan kepatuhan berlalu lintas.</p>',
                'sources' => [['UPPD Barabai', 'https://uppdbarabai.com/uppd-barabai-bersama-bpkpd-hst-jasa-raharja-dan-satlantas-polres-hst-gencarkan-sosialisasi-program-pemutihan-pkb-di-tugu-burung-anggang/']],
            ],
            [
                'title' => 'Rancangan Perubahan APBD HST 2026 Diserahkan, PAD Diproyeksikan Naik Menjadi Rp261,55 Miliar',
                'date' => '2026-08-18',
                'image' => 'apbd.jpg',
                'excerpt' => 'Total pendapatan daerah diproyeksikan Rp1,74 triliun, turun Rp17,18 miliar, sementara pendapatan asli daerah justru naik.',
                'body' => '<p>Pemerintah Kabupaten Hulu Sungai Tengah menyerahkan Rancangan Perubahan APBD Tahun Anggaran 2026 kepada DPRD HST dalam rapat paripurna di Gedung DPRD Lantai II, Barabai.</p>'
                    .'<p>Perubahan anggaran disusun karena sejumlah asumsi dalam Kebijakan Umum Anggaran (KUA) dinilai tidak lagi sesuai dengan kondisi riil. Penyusunannya mempertimbangkan realisasi anggaran semester pertama dan hasil audit BPK RI.</p>'
                    .'<ul><li>Total pendapatan daerah diproyeksikan <strong>Rp1,74 triliun</strong>, turun Rp17,18 miliar dari target sebelumnya.</li>'
                    .'<li>Pendapatan asli daerah (PAD) diproyeksikan naik menjadi <strong>Rp261,55 miliar</strong>.</li>'
                    .'<li>Pagu belanja disesuaikan menjadi Rp1,88 triliun.</li>'
                    .'<li>Selisih pembiayaan sebesar Rp144,05 miliar ditutup dengan SiLPA tahun sebelumnya.</li></ul>'
                    .'<p>Bupati Samsul Rizal meminta dokumen tersebut dibahas bersama DPRD agar kebijakan anggaran tepat sasaran.</p>',
                'sources' => [
                    ['RadigfaMedia Kalsel', 'https://kalsel.radigfamedia.com/pemkab-hst-serahkan-perubahan-apbd-2026-pendapatan-turun-rp1718-miliar-dan-pad-justru-naik/'],
                    ['Grapena', 'https://www.grapena.com/2026/08/hadapi-dinamika-ekonomi-pemkab-hst.html'],
                ],
            ],
            [
                'title' => 'Samsat Keliling Hadir di Halaman Kantor BPKPD HST, Wajib Pajak Dapat Souvenir',
                'date' => '2026-08-04',
                'image' => 'samsat.jpg',
                'excerpt' => 'Wajib pajak dapat membayar PKB tanpa harus datang ke kantor Samsat. BPKPD HST menyediakan souvenir sebagai bentuk apresiasi.',
                'body' => '<p>UPPD/Samsat Barabai menghadirkan layanan Samsat Keliling (Samkel) di halaman depan Kantor BPKPD Kabupaten Hulu Sungai Tengah. Layanan ini memudahkan wajib pajak membayar Pajak Kendaraan Bermotor (PKB) tanpa harus datang ke kantor Samsat.</p>'
                    .'<p>Sebagai bentuk apresiasi, BPKPD HST menyediakan souvenir bagi wajib pajak yang membayar PKB melalui Samsat Keliling selama kegiatan berlangsung.</p>'
                    .'<p>Kegiatan ini merupakan hasil sinergi UPPD Barabai dan BPKPD HST untuk mempermudah akses layanan serta menumbuhkan kesadaran kepatuhan membayar PKB sebagai salah satu sumber pendapatan daerah. Masyarakat diajak memanfaatkan Samsat Keliling dan membayar pajak kendaraan tepat waktu.</p>',
                'sources' => [['UPPD Barabai', 'https://uppdbarabai.com/permudah-layanan-pkb-uppd-barabai-gelar-samsat-keliling-di-kantor-bpkpd-hst-disertai-souvenir-bagi-wajib-pajak/']],
            ],
            [
                'title' => 'BPKPD HST dan Bank Kalsel Teken Kesepakatan Kartu Kredit Indonesia untuk Belanja Pemerintah Daerah',
                'date' => '2026-06-04',
                'image' => 'kki.jpg',
                'excerpt' => 'Belanja barang dan jasa di lingkungan Pemkab HST beralih ke transaksi nontunai yang lebih akuntabel dan dapat dipantau secara real-time.',
                'body' => '<p>Pemerintah Kabupaten Hulu Sungai Tengah mulai menerapkan Kartu Kredit Indonesia (KKI) melalui kerja sama dengan Bank Kalsel. Kesepakatan ditandatangani oleh BPKPD Hulu Sungai Tengah dan Bank Kalsel di sela High Level Meeting dan peningkatan kapasitas Tim Percepatan dan Perluasan Digitalisasi Daerah (TP2DD) di Banjarmasin.</p>'
                    .'<p>Dengan sistem ini, belanja barang dan jasa di lingkungan birokrasi beralih ke transaksi nontunai yang lebih akuntabel. Penyerapan anggaran juga dapat dipantau secara real-time.</p>'
                    .'<p>Bupati Samsul Rizal, yang membuka kegiatan tersebut, menyatakan elektronifikasi transaksi pemerintahan diperlukan untuk mendongkrak pendapatan asli daerah. Ia juga meminta seluruh kepala dinas mengintegrasikan sistem digital dalam pekerjaan sehari-hari. Kantor Perwakilan Bank Indonesia Provinsi Kalimantan Selatan turut mendampingi kesiapan sumber daya manusia dalam mengoperasikan sistem ini.</p>',
                'sources' => [['Grapena', 'https://www.grapena.com/2026/06/gandeng-bank-kalsel-pemkab-hst.html']],
            ],
        ];
    }
}
