<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Message;
use App\Models\Photo;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => [
                ['Berita', Post::count(), 'newspaper', 'admin.posts'],
                ['Pengumuman', Announcement::count(), 'megaphone', 'admin.announcements'],
                ['Foto', Photo::count(), 'image', 'admin.photos'],
                ['Dokumen', Document::count(), 'file', 'admin.documents'],
                ['Pegawai', Employee::count(), 'users', 'admin.employees'],
                ['Pesan belum dibaca', Message::whereNull('read_at')->count(), 'inbox', 'admin.messages'],
            ],
            'totalViews' => Post::sum('views'),
            'totalDownloads' => Document::sum('downloads'),
            'popular' => Post::orderByDesc('views')->take(5)->get(),
            'messages' => Message::latest()->take(5)->get(),
        ]);
    }
}
