# Website BPKPD Kabupaten Hulu Sungai Tengah

Website resmi dan CMS Badan Pengelolaan Keuangan dan Pendapatan Daerah (BPKPD) Kabupaten Hulu Sungai Tengah.
Pengganti situs lama `bpkpd.hstkab.go.id` + `admin-bpkpd.hstkab.go.id`.

**Stack:** Laravel 13, Livewire 4 (Alpine.js bawaan), Tailwind CSS 4, Vite, Trix editor.
**Butuh:** PHP 8.3+, Composer, Node.js 20+.

## Fitur

**Website publik** (animasi reveal saat scroll, hero slider, counter, marquee, desain responsif):
Beranda, Profil (tentang, tugas & fungsi, visi misi), Struktur Organisasi, Data Pegawai (dengan pencarian),
Layanan & persyaratan, Berita (pencarian live), Pengumuman, Galeri (lightbox), Dokumen (filter jenis & tahun), Kontak (form + peta).
Alamat lama situs sebelumnya (`/profil/tugas_fungsi`, `/kontak_kami`, dst.) otomatis diarahkan ke alamat baru.

**CMS** di `/admin`: Dashboard, Pesan Masuk, Carousel, Berita, Pengumuman, Galeri Foto, Dokumen, Profil Instansi
(identitas, logo, visi misi, tugas fungsi, pimpinan, bagan struktur, kontak), Data Pegawai, Pelayanan, Jenis Pelayanan,
Media Sosial, Link Terkait, Pengguna, Akun Saya.

## Menjalankan di Laragon (Windows)

```bash
cd D:\laragon\www
git clone https://github.com/HanifAuliya/bpkpd-landingpage.git
cd bpkpd-landingpage
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build        # atau `npm run dev` saat mengembangkan
```

Buka `http://bpkpd-landingpage.test` (Laragon membuat virtual host otomatis setelah reload) atau jalankan `php artisan serve`.
Setelah virtual host aktif, ubah `APP_URL` di `.env` menjadi `http://bpkpd-landingpage.test` supaya gambar yang diunggah tampil.

Login CMS: `http://bpkpd-landingpage.test/admin` dengan `ADMIN_EMAIL` / `ADMIN_PASSWORD` dari `.env`
(bawaan `admin@bpkpd.test` / `password`). **Ganti password lewat menu Akun Saya sebelum online.**

### Pakai MySQL (opsional)

Bawaan memakai SQLite (`database/database.sqlite`). Untuk MySQL Laragon, ubah `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bpkpd
DB_USERNAME=root
DB_PASSWORD=
```

lalu `php artisan migrate --seed`.

## Data awal

Seeder mengisi profil, visi misi, tugas fungsi, 21 data pegawai, layanan, jenis pelayanan, media sosial, dan link terkait
dari situs lama. Di environment `local` ditambah 3 berita dan 1 pengumuman berlabel **[Contoh]** yang bisa dihapus dari CMS.
Foto (carousel, pegawai, kepala, bagan struktur, logo) diunggah lewat CMS.

## Tes

```bash
php artisan test
```

## Deploy (ringkas)

`APP_ENV=production`, `APP_DEBUG=false`, set `APP_URL` ke domain, `composer install --no-dev -o`, `npm run build`,
`php artisan migrate --force`, `php artisan storage:link`, `php artisan optimize`.
