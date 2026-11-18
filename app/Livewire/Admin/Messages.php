<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Pesan Masuk')]
class Messages extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public ?int $selectedId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function open(int $id): void
    {
        $msg = Message::findOrFail($id);
        $msg->read_at ??= now();
        $msg->save();
        $this->selectedId = $id;
    }

    public function markUnread(int $id): void
    {
        Message::whereKey($id)->update(['read_at' => null]);
        $this->selectedId = null;
    }

    public function delete(int $id): void
    {
        Message::whereKey($id)->delete();
        $this->selectedId = null;
        $this->dispatch('toast', message: 'Pesan dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.messages', [
            'messages' => Message::query()
                ->when($this->search, fn ($q) => $q->where(fn ($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")->orWhere('subject', 'like', "%{$this->search}%")->orWhere('body', 'like', "%{$this->search}%")))
                ->latest()->paginate(15),
            'selected' => $this->selectedId ? Message::find($this->selectedId) : null,
        ]);
    }
}
