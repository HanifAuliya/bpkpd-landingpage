<?php

use App\Http\Controllers\PageController;
use App\Livewire;
use Illuminate\Support\Facades\Route;

/* Halaman publik */
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/profil', 'profil')->name('profil');
    Route::get('/profil/struktur-organisasi', 'struktur')->name('profil.struktur');
    Route::get('/profil/pegawai', 'pegawai')->name('profil.pegawai');
    Route::get('/layanan', 'layanan')->name('layanan');
    Route::get('/berita/{post}', 'beritaShow')->name('berita.show');
    Route::get('/pengumuman', 'pengumumanIndex')->name('pengumuman.index');
    Route::get('/pengumuman/{announcement}', 'pengumumanShow')->name('pengumuman.show');
    Route::get('/galeri', 'galeri')->name('galeri');
    Route::get('/dokumen/{document}/unduh', 'unduh')->name('dokumen.unduh');
});
Route::get('/berita', Livewire\Public\BeritaIndex::class)->name('berita.index');
Route::get('/dokumen', Livewire\Public\DokumenIndex::class)->name('dokumen');
Route::get('/kontak', Livewire\Public\Kontak::class)->name('kontak');

/* Alamat lama dari situs sebelumnya, supaya tautan lama tetap jalan */
Route::permanentRedirect('/profil/tugas_fungsi', '/profil');
Route::permanentRedirect('/profil/visi_misi', '/profil#visi-misi');
Route::permanentRedirect('/profil/struktur_organisasi', '/profil/struktur-organisasi');
Route::permanentRedirect('/profil/data_pegawai', '/profil/pegawai');
Route::permanentRedirect('/foto', '/galeri');
Route::permanentRedirect('/kontak_kami', '/kontak');

/* CMS */
Route::get('/admin/login', Livewire\Auth\Login::class)->middleware('guest')->name('login');
Route::post('/admin/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/carousel', Livewire\Admin\Sliders::class)->name('sliders');
    Route::get('/profil', Livewire\Admin\Settings::class)->name('settings');
    Route::get('/pegawai', Livewire\Admin\Employees::class)->name('employees');
    Route::get('/berita', Livewire\Admin\Posts::class)->name('posts');
    Route::get('/pengumuman', Livewire\Admin\Announcements::class)->name('announcements');
    Route::get('/foto', Livewire\Admin\Photos::class)->name('photos');
    Route::get('/dokumen', Livewire\Admin\Documents::class)->name('documents');
    Route::get('/pelayanan', Livewire\Admin\Services::class)->name('services');
    Route::get('/jenis-pelayanan', Livewire\Admin\ServiceTypes::class)->name('service-types');
    Route::get('/sosmed', Livewire\Admin\SocialLinks::class)->name('social-links');
    Route::get('/link-terkait', Livewire\Admin\RelatedLinks::class)->name('related-links');
    Route::get('/pesan', Livewire\Admin\Messages::class)->name('messages');
    Route::get('/pengguna', Livewire\Admin\Users::class)->name('users');
    Route::get('/akun', Livewire\Admin\Account::class)->name('account');
});
