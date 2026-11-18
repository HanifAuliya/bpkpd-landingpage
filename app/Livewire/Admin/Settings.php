<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Profil Instansi')]
class Settings extends Component
{
    use WithFileUploads;

    #[Url]
    public string $tab = 'umum';

    public array $form = [];

    public array $uploads = [];

    public const TEXT_KEYS = [
        'nama_dinas', 'nama_singkat', 'daerah', 'tagline', 'deskripsi',
        'visi', 'misi', 'tugas', 'fungsi',
        'kepala_nama', 'kepala_jabatan', 'sambutan',
        'alamat', 'email', 'telepon', 'jam_layanan', 'maps_query',
    ];

    public const IMAGE_KEYS = ['logo', 'kepala_foto', 'struktur_image'];

    public function mount(): void
    {
        foreach (self::TEXT_KEYS as $key) {
            $this->form[$key] = (string) setting($key, '');
        }
    }

    public function tabs(): array
    {
        return [
            'umum' => ['Identitas', 'building'],
            'visi' => ['Visi, Misi, Tugas & Fungsi', 'target'],
            'kepala' => ['Pimpinan & Struktur', 'user'],
            'kontak' => ['Kontak', 'map-pin'],
        ];
    }

    public function save(): void
    {
        $this->validate([
            'form.nama_dinas' => 'required|string|max:200',
            'form.nama_singkat' => 'required|string|max:30',
            'form.email' => 'nullable|email',
            'form.*' => 'nullable|string|max:20000',
            'uploads.*' => 'nullable|image|max:6144',
        ], [], ['form.nama_dinas' => 'nama instansi', 'form.nama_singkat' => 'nama singkat']);

        $values = $this->form;
        foreach (self::IMAGE_KEYS as $key) {
            if (isset($this->uploads[$key])) {
                if ($old = setting($key)) {
                    Storage::disk('public')->delete($old);
                }
                $values[$key] = $this->uploads[$key]->store('profil', 'public');
            }
        }
        Setting::put($values);
        $this->uploads = [];
        $this->dispatch('toast', message: 'Profil instansi disimpan.');
    }

    public function removeImage(string $key): void
    {
        abort_unless(in_array($key, self::IMAGE_KEYS), 404);
        unset($this->uploads[$key]);
        if ($old = setting($key)) {
            Storage::disk('public')->delete($old);
            Setting::put([$key => null]);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
