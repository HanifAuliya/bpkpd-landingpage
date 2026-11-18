<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Photo;
use App\Models\Post;
use App\Models\RelatedLink;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'sliders' => Slider::active()->get(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'posts' => Post::published()->take(4)->get(),
            'announcements' => Announcement::published()->take(5)->get(),
            'photos' => Photo::latest()->take(7)->get(),
            'relatedLinks' => RelatedLink::orderBy('sort_order')->get(),
            'stats' => [
                'layanan' => Service::where('is_active', true)->count(),
                'pegawai' => Employee::count(),
                'berita' => Post::published()->count() + Announcement::published()->count(),
                'dokumen' => Document::count(),
            ],
        ]);
    }

    public function profil()
    {
        return view('pages.profil');
    }

    public function struktur()
    {
        return view('pages.struktur', ['leaders' => Employee::orderBy('sort_order')->take(4)->get()]);
    }

    public function pegawai()
    {
        return view('pages.pegawai', ['employees' => Employee::orderBy('sort_order')->get()]);
    }

    public function layanan()
    {
        return view('pages.layanan', [
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'types' => ServiceType::orderBy('sort_order')->get(),
        ]);
    }

    public function beritaShow(Post $post)
    {
        abort_unless($post->is_published && $post->published_at <= now(), 404);
        $post->increment('views');

        return view('pages.berita-show', [
            'post' => $post,
            'related' => Post::published()->whereKeyNot($post->id)->take(3)->get(),
        ]);
    }

    public function pengumumanIndex()
    {
        return view('pages.pengumuman-index', ['items' => Announcement::published()->paginate(10)]);
    }

    public function pengumumanShow(Announcement $announcement)
    {
        abort_unless($announcement->is_published, 404);

        return view('pages.pengumuman-show', [
            'item' => $announcement,
            'others' => Announcement::published()->whereKeyNot($announcement->id)->take(5)->get(),
        ]);
    }

    public function galeri()
    {
        return view('pages.galeri', ['photos' => Photo::latest('taken_at')->latest()->get()]);
    }

    public function unduh(Document $document)
    {
        $document->increment('downloads');
        abort_unless(Storage::disk('public')->exists($document->file), 404);

        return Storage::disk('public')->download($document->file, str($document->name)->slug().'.'.pathinfo($document->file, PATHINFO_EXTENSION));
    }
}
