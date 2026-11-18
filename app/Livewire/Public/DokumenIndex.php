<?php

namespace App\Livewire\Public;

use App\Models\Document;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
#[Title('Dokumen')]
class DokumenIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $jenis = '';

    #[Url(except: '')]
    public string $tahun = '';

    public function updated(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.public.dokumen-index', [
            'documents' => Document::query()
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->when($this->jenis, fn ($q) => $q->where('type', $this->jenis))
                ->when($this->tahun, fn ($q) => $q->where('year', $this->tahun))
                ->latest('year')->latest()
                ->paginate(15),
            'types' => Document::whereNotNull('type')->distinct()->orderBy('type')->pluck('type'),
            'years' => Document::whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year'),
        ]);
    }
}
