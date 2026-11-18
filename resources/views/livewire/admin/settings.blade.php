@php
    $text = function ($key, $label, $hint = null, $rows = null, $span = 2) {
        return compact('key', 'label', 'hint', 'rows', 'span');
    };
    $groups = [
        'umum' => [
            $text('nama_dinas', 'Nama instansi'),
            $text('nama_singkat', 'Nama singkat', null, null, 1),
            $text('daerah', 'Daerah', null, null, 1),
            $text('tagline', 'Tagline', 'Kalimat singkat untuk footer dan mesin pencari.'),
            $text('deskripsi', 'Deskripsi instansi', 'Tampil di beranda dan halaman profil.', 6),
            ['image' => 'logo', 'label' => 'Logo', 'hint' => 'PNG transparan, rasio persegi. Kosongkan untuk logo bawaan.'],
        ],
        'visi' => [
            $text('visi', 'Visi', null, 2),
            $text('misi', 'Misi', 'Satu misi per baris.', 5),
            $text('tugas', 'Tugas pokok', null, 4),
            $text('fungsi', 'Fungsi', 'Satu fungsi per baris.', 9),
        ],
        'kepala' => [
            $text('kepala_nama', 'Nama kepala', null, null, 1),
            $text('kepala_jabatan', 'Jabatan', null, null, 1),
            $text('sambutan', 'Kata sambutan', null, 5),
            ['image' => 'kepala_foto', 'label' => 'Foto kepala', 'hint' => 'Rasio 4:3, wajah di bagian atas.'],
            ['image' => 'struktur_image', 'label' => 'Bagan struktur organisasi', 'hint' => 'Jika kosong, bagan dibuat otomatis dari 4 pegawai teratas.'],
        ],
        'kontak' => [
            $text('alamat', 'Alamat', null, 2),
            $text('email', 'Email', null, null, 1),
            $text('telepon', 'Telepon', null, null, 1),
            $text('jam_layanan', 'Jam pelayanan', 'Satu baris per hari/jadwal.', 3),
            $text('maps_query', 'Lokasi peta', 'Teks pencarian Google Maps, misalnya nama kantor dan jalan.'),
        ],
    ];
@endphp
<div>
    <x-admin.page-header title="Profil Instansi" description="Identitas, visi misi, pimpinan, dan kontak yang tampil di website." />

    <div class="grid gap-6 lg:grid-cols-4">
        <nav class="card h-fit space-y-1 p-2">
            @foreach ($this->tabs() as $key => [$label, $icon])
                <button wire:click="$set('tab', '{{ $key }}')" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold transition {{ $tab === $key ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    <x-icon :name="$icon" class="size-4" /> {{ $label }}
                </button>
            @endforeach
        </nav>

        <form wire:submit="save" class="card lg:col-span-3">
            <div class="grid grid-cols-2 gap-5 p-6 sm:p-8">
                @foreach ($groups[$tab] ?? [] as $f)
                    <div class="{{ ($f['span'] ?? 2) === 1 ? 'col-span-2 sm:col-span-1' : 'col-span-2' }}" wire:key="{{ $tab }}-{{ $f['key'] ?? $f['image'] }}">
                        <label class="form-label">{{ $f['label'] }}</label>
                        @isset($f['image'])
                            @php $k = $f['image']; $existing = setting($k); $up = $uploads[$k] ?? null; @endphp
                            <div class="flex flex-wrap items-center gap-4 rounded-2xl border border-dashed border-slate-300 p-4">
                                <div class="grid h-24 w-32 place-items-center overflow-hidden rounded-xl bg-slate-50">
                                    @if ($up)<img src="{{ $up->temporaryUrl() }}" class="size-full object-contain" alt="">
                                    @elseif ($existing)<img src="{{ media($existing) }}" class="size-full object-contain" alt="">
                                    @else<x-icon name="image" class="size-8 text-slate-300" />@endif
                                </div>
                                <div class="flex gap-2">
                                    <label class="btn-outline cursor-pointer !py-2 text-xs">
                                        <x-icon name="upload" class="size-4" /> {{ $existing || $up ? 'Ganti' : 'Unggah' }}
                                        <input type="file" accept="image/*" wire:model="uploads.{{ $k }}" class="sr-only">
                                    </label>
                                    @if ($existing || $up)
                                        <button type="button" wire:click="removeImage('{{ $k }}')" wire:confirm="Hapus gambar ini?" class="btn !py-2 text-xs text-rose-600 hover:bg-rose-50"><x-icon name="trash" class="size-4" /></button>
                                    @endif
                                </div>
                                <span wire:loading wire:target="uploads.{{ $k }}" class="text-xs text-slate-400">Mengunggah...</span>
                            </div>
                            @error("uploads.$k")<p class="form-error">{{ $message }}</p>@enderror
                        @else
                            @if ($f['rows'])
                                <textarea wire:model="form.{{ $f['key'] }}" rows="{{ $f['rows'] }}" class="form-input"></textarea>
                            @else
                                <input wire:model="form.{{ $f['key'] }}" class="form-input">
                            @endif
                            @error("form.{$f['key']}")<p class="form-error">{{ $message }}</p>@enderror
                        @endisset
                        @if ($f['hint'] ?? null)<p class="mt-1.5 text-xs text-slate-400">{{ $f['hint'] }}</p>@endif
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end border-t border-slate-100 bg-slate-50/60 px-6 py-4 sm:px-8">
                <button class="btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
