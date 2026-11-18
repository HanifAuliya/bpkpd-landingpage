<?php

namespace App\Livewire\Public;

use App\Models\Message;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Kontak')]
class Kontak extends Component
{
    #[Validate('required|string|max:100', as: 'nama')]
    public string $name = '';

    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('nullable|string|max:30', as: 'nomor telepon')]
    public string $phone = '';

    #[Validate('nullable|string|max:150', as: 'subjek')]
    public string $subject = '';

    #[Validate('required|string|min:10|max:3000', as: 'pesan')]
    public string $body = '';

    /** Honeypot: harus tetap kosong. */
    public string $website = '';

    public bool $sent = false;

    public function send(): void
    {
        $this->validate();

        $key = 'kontak:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('body', 'Terlalu banyak pesan. Coba lagi dalam beberapa menit.');

            return;
        }
        RateLimiter::hit($key, 600);

        if ($this->website === '') {
            Message::create($this->only(['name', 'email', 'phone', 'subject', 'body']));
        }

        $this->reset(['name', 'email', 'phone', 'subject', 'body']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.public.kontak');
    }
}
