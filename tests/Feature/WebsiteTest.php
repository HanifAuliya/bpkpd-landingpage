<?php

namespace Tests\Feature;

use App\Livewire\Admin\Posts;
use App\Livewire\Public\Kontak;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\BeritaHstSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
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

    public function test_seeded_news_is_listed_with_its_source(): void
    {
        $post = Post::published()->first();

        $this->assertSame(7, Post::published()->count());
        $this->assertSame(7, Post::whereNotNull('image')->count());
        Storage::disk('public')->assertExists($post->image);
        $this->get('/berita')->assertOk()->assertSee($post->title);
        $this->get(route('berita.show', $post))->assertOk()->assertSee('Disarikan dari pemberitaan', false);
    }

    public function test_news_seeder_does_not_duplicate_posts(): void
    {
        $this->seed(BeritaHstSeeder::class);

        $this->assertSame(7, Post::count());
    }

    public function test_home_shows_building_photo_and_theme_toggle(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('images/gedung-bpkpd.jpg', false)
            ->assertSee('$store.theme.toggle()', false);
    }
}
