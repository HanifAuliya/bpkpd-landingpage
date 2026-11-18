<?php

namespace App\Livewire\Public;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
#[Title('Berita')]
class BeritaIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::published()
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('body', 'like', "%{$this->search}%")))
            ->paginate(9);

        return view('livewire.public.berita-index', [
            'posts' => $posts,
            'featured' => $this->search === '' && $posts->currentPage() === 1 ? $posts->first() : null,
        ]);
    }
}
