<?php

namespace Tests\Feature;

use App\Livewire\Admin\Posts;
use App\Livewire\Public\Kontak;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/profil', '/profil/struktur-organisasi', '/profil/pegawai', '/layanan', '/berita', '/pengumuman', '/galeri', '/dokumen', '/kontak'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/')->assertSee('SIPANDA');
    }

    public function test_old_urls_redirect(): void
    {
        $this->get('/profil/data_pegawai')->assertRedirect('/profil/pegawai');
    }

    public function test_published_post_is_visible_and_counts_views(): void
    {
        $post = Post::create(['title' => 'Berita Uji', 'body' => '<p>Isi</p>', 'is_published' => true]);
        $this->get(route('berita.show', $post))->assertOk()->assertSee('Berita Uji');
        $this->assertSame(1, $post->fresh()->views);
    }

    public function test_draft_post_is_hidden(): void
    {
        $post = Post::create(['title' => 'Draf', 'body' => 'x', 'is_published' => false]);
        $this->get(route('berita.show', $post))->assertNotFound();
    }

    public function test_contact_form_stores_message(): void
    {
        Livewire::test(Kontak::class)
            ->set('name', 'Budi')->set('email', 'budi@example.com')->set('body', 'Pertanyaan tentang PBB-P2.')
            ->call('send')->assertHasNoErrors()->assertSet('sent', true);
        $this->assertSame(1, Message::count());
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_pages_load(): void
    {
        $this->actingAs(User::first());
        foreach (['', '/carousel', '/profil', '/pegawai', '/berita', '/pengumuman', '/foto', '/dokumen', '/pelayanan', '/jenis-pelayanan', '/sosmed', '/link-terkait', '/pesan', '/pengguna', '/akun'] as $url) {
            $this->get('/admin'.$url)->assertOk();
        }
    }

    public function test_admin_can_create_post(): void
    {
        $this->actingAs(User::first());
        Livewire::test(Posts::class)
            ->call('create')
            ->set('form.title', 'Berita dari CMS')
            ->set('form.body', '<p>Isi berita</p>')
            ->call('save')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('posts', ['title' => 'Berita dari CMS', 'slug' => 'berita-dari-cms']);
    }
}
