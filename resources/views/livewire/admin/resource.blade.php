@php
    $icons = ['receipt', 'home', 'search', 'boxes', 'clipboard', 'grid', 'file', 'wallet', 'chart', 'shield', 'users', 'building', 'globe', 'calendar', 'megaphone', 'newspaper', 'sparkles', 'target', 'mail', 'phone'];
@endphp
<div>
    <x-admin.page-header :title="$title" :description="$description">
        <button wire:click="create" class="btn-primary"><x-icon name="plus" class="size-4" /> Tambah {{ strtolower($singular) }}</button>
    </x-admin.page-header>

    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 p-4">
            <div class="relative w-full max-w-xs">
                <x-icon name="search" class="absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-slate-400" />
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari..." class="form-input !pl-10">
            </div>
            <span wire:loading class="text-sm text-slate-400">Memuat...</span>
            <span class="ml-auto text-sm text-slate-400">{{ $records->total() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <tr>
                        @if ($sortable)<th class="w-16 px-4 py-3">Urut</th>@endif
                        @foreach ($columns as $col)<th class="px-4 py-3">{{ $col['label'] }}</th>@endforeach
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($records as $record)
                        <tr wire:key="row-{{ $record->id }}" class="transition hover:bg-brand-50/40">
                            @if ($sortable)
                                <td class="px-4 py-3">
                                    <div class="flex flex-col text-slate-400">
                                        <button wire:click="moveUp({{ $record->id }})" class="hover:text-brand-600" aria-label="Naik"><x-icon name="chevron-down" class="size-4 rotate-180" /></button>
                                        <button wire:click="moveDown({{ $record->id }})" class="hover:text-brand-600" aria-label="Turun"><x-icon name="chevron-down" class="size-4" /></button>
                                    </div>
                                </td>
                            @endif
                            @foreach ($columns as $key => $col)
                                @php $value = $record->getAttribute($key); @endphp
                                <td class="px-4 py-3 align-middle">
                                    @switch($col['type'] ?? 'text')
                                        @case('image')
                                            <div class="h-12 w-20 overflow-hidden rounded-lg bg-slate-100">
                                                @if ($value)<img src="{{ media($value) }}" alt="" class="size-full object-cover">@else<div class="grid size-full place-items-center text-slate-300"><x-icon name="image" class="size-5" /></div>@endif
                                            </div>
                                            @break
                                        @case('avatar')
                                            <div class="size-11 overflow-hidden rounded-full bg-brand-50">
                                                @if ($value)<img src="{{ media($value) }}" alt="" class="size-full object-cover object-top">@else<div class="grid size-full place-items-center text-brand-400"><x-icon name="user" class="size-5" /></div>@endif
                                            </div>
                                            @break
                                        @case('toggle')
                                            <button wire:click="toggle({{ $record->id }}, '{{ $key }}')" role="switch" aria-checked="{{ $value ? 'true' : 'false' }}"
                                                class="relative h-6 w-11 rounded-full transition {{ $value ? 'bg-brand-500' : 'bg-slate-200' }}">
                                                <span class="absolute top-0.5 size-5 rounded-full bg-white shadow transition-all {{ $value ? 'left-[22px]' : 'left-0.5' }}"></span>
                                            </button>
                                            @break
                                        @case('icon')
                                            <span class="grid size-10 place-items-center rounded-xl bg-brand-50 text-brand-600"><x-icon :name="$value" /></span>
                                            @break
                                        @case('icon-label')
                                            <span class="inline-flex items-center gap-2 font-semibold capitalize text-slate-800"><x-icon :name="$value" class="size-4 text-brand-600" /> {{ $value }}</span>
                                            @break
                                        @case('url')
                                            @if ($value)<a href="{{ $value }}" target="_blank" rel="noopener" class="inline-flex max-w-56 items-center gap-1 truncate text-brand-700 hover:underline">{{ \Illuminate\Support\Str::limit(preg_replace('#^https?://#', '', $value), 35) }} <x-icon name="arrow-up-right" class="size-3.5" /></a>@endif
                                            @break
                                        @case('file')
                                            @if ($value)<a href="{{ media($value) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 hover:bg-brand-50 hover:text-brand-700"><x-icon name="file" class="size-3.5" /> {{ strtoupper(pathinfo($value, PATHINFO_EXTENSION)) }}</a>@else<span class="text-slate-300">-</span>@endif
                                            @break
                                        @case('number')
                                            <span class="font-semibold tabular-nums text-slate-600">{{ number_format((int) $value) }}</span>
                                            @break
                                        @case('date')
                                            <span class="text-slate-500">{{ $value?->translatedFormat('d M Y') }}</span>
                                            @break
                                        @default
                                            <div class="max-w-md">
                                                <p class="font-semibold text-slate-800">
                                                    @if (isset($col['link']) && ($record->is_published ?? false))
                                                        <a href="{{ route($col['link'], $record) }}" target="_blank" class="hover:text-brand-700">{{ \Illuminate\Support\Str::limit($value, 80) }}</a>
                                                    @else
                                                        {{ \Illuminate\Support\Str::limit($value, 80) }}
                                                    @endif
                                                </p>
                                                @isset($col['sub'])
                                                    @php $sub = $record->getAttribute($col['sub']); @endphp
                                                    <p class="mt-0.5 line-clamp-1 text-xs text-slate-400">{{ $sub instanceof \DateTimeInterface ? $sub->translatedFormat('d M Y, H:i') : $sub }}</p>
                                                @endisset
                                            </div>
                                    @endswitch
                                </td>
                            @endforeach
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <button wire:click="edit({{ $record->id }})" class="inline-grid size-9 place-items-center rounded-lg text-slate-500 hover:bg-brand-50 hover:text-brand-700" title="Ubah"><x-icon name="pencil" class="size-4" /></button>
                                <button wire:click="delete({{ $record->id }})" wire:confirm="Hapus {{ strtolower($singular) }} ini? Tindakan ini tidak bisa dibatalkan." class="inline-grid size-9 place-items-center rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600" title="Hapus"><x-icon name="trash" class="size-4" /></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="px-4 py-16 text-center">
                                <x-icon name="inbox" class="mx-auto size-10 text-slate-300" />
                                <p class="mt-3 text-slate-500">{{ $search ? 'Tidak ada hasil untuk "'.$search.'".' : 'Belum ada data.' }}</p>
                                @unless ($search)<button wire:click="create" class="btn-primary mt-5"><x-icon name="plus" class="size-4" /> Tambah {{ strtolower($singular) }}</button>@endunless
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($records->hasPages())<div class="border-t border-slate-100 p-4">{{ $records->links() }}</div>@endif
    </div>

    {{-- Slide-over form --}}
    <div x-data x-show="$wire.showForm" x-cloak class="fixed inset-0 z-50" @keydown.escape.window="$wire.showForm = false">
        <div x-show="$wire.showForm" x-transition.opacity class="absolute inset-0 bg-ink/50 backdrop-blur-sm" @click="$wire.showForm = false"></div>
        <div x-show="$wire.showForm"
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute inset-y-0 right-0 flex w-full {{ $wide ? 'max-w-3xl' : 'max-w-xl' }} flex-col bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-600">{{ $editingId ? 'Ubah' : 'Tambah' }}</p>
                    <h2 class="text-lg font-extrabold text-slate-900">{{ $singular }}</h2>
                </div>
                <button type="button" @click="$wire.showForm = false" class="grid size-10 place-items-center rounded-full text-slate-400 hover:bg-slate-100" aria-label="Tutup"><x-icon name="x" /></button>
            </div>

            <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                <div class="grid flex-1 grid-cols-2 content-start gap-5 overflow-y-auto p-6">
                    @foreach ($fields as $name => $field)
                        @php $type = $field['type'] ?? 'text'; @endphp
                        <div class="{{ ($field['span'] ?? 2) === 1 ? 'col-span-2 sm:col-span-1' : 'col-span-2' }}" wire:key="field-{{ $name }}-{{ $editingId ?? 'new' }}">
                            @if ($type !== 'toggle')
                                <label class="form-label" for="f-{{ $name }}">{{ $field['label'] }} @if($field['required'] ?? false)<span class="text-rose-500">*</span>@endif</label>
                            @endif

                            @switch($type)
                                @case('textarea')
                                    <textarea id="f-{{ $name }}" wire:model="form.{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" class="form-input"></textarea>
                                    @break
                                @case('richtext')
                                    <div wire:ignore x-data="richtext('form.{{ $name }}')">
                                        <input id="trix-{{ $name }}-{{ $editingId ?? 'new' }}" type="hidden" value="{{ $form[$name] ?? '' }}">
                                        <trix-editor x-ref="trix" input="trix-{{ $name }}-{{ $editingId ?? 'new' }}" class="prose-content"></trix-editor>
                                    </div>
                                    @break
                                @case('toggle')
                                    <label class="mt-7 flex cursor-pointer items-center gap-3">
                                        <input type="checkbox" wire:model="form.{{ $name }}" class="peer sr-only">
                                        <span class="relative h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-brand-500 after:absolute after:left-0.5 after:top-0.5 after:size-5 after:rounded-full after:bg-white after:shadow after:transition-all peer-checked:after:left-[22px]"></span>
                                        <span class="text-sm font-semibold text-slate-700">{{ $field['label'] }}</span>
                                    </label>
                                    @break
                                @case('select')
                                    <select id="f-{{ $name }}" wire:model="form.{{ $name }}" class="form-input">
                                        <option value="">Pilih...</option>
                                        @foreach ($field['options'] as $val => $lbl)<option value="{{ $val }}">{{ $lbl }}</option>@endforeach
                                    </select>
                                    @break
                                @case('icon')
                                    <div class="grid grid-cols-6 gap-2 sm:grid-cols-10">
                                        @foreach ($icons as $icon)
                                            <button type="button" wire:click="$set('form.{{ $name }}', '{{ $icon }}')" title="{{ $icon }}"
                                                class="grid aspect-square place-items-center rounded-xl border transition {{ ($form[$name] ?? '') === $icon ? 'border-brand-500 bg-brand-50 text-brand-700 ring-4 ring-brand-500/15' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                                                <x-icon :name="$icon" />
                                            </button>
                                        @endforeach
                                    </div>
                                    @break
                                @case('image')
                                @case('file')
                                    @php $existing = $current?->getAttribute($name); $upload = $uploads[$name] ?? null; @endphp
                                    <div x-data="{ dragging: false, progress: 0, uploading: false }"
                                         x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        @if ($upload || $existing)
                                            <div class="flex items-center gap-4 rounded-xl border border-slate-200 p-3">
                                                @if ($type === 'image')
                                                    <img src="{{ $upload ? $upload->temporaryUrl() : media($existing) }}" alt="" class="h-20 w-28 rounded-lg object-cover">
                                                @else
                                                    <span class="grid size-12 place-items-center rounded-lg bg-brand-50 text-brand-600"><x-icon name="file" /></span>
                                                @endif
                                                <div class="min-w-0 flex-1 text-sm">
                                                    <p class="truncate font-semibold text-slate-700">{{ $upload ? $upload->getClientOriginalName() : basename($existing) }}</p>
                                                    <p class="text-xs text-slate-400">{{ $upload ? 'File baru, belum disimpan' : 'File saat ini' }}</p>
                                                </div>
                                                <label class="btn-outline cursor-pointer !px-3 !py-1.5 text-xs">Ganti<input type="file" wire:model="uploads.{{ $name }}" class="sr-only" @if($type === 'image') accept="image/*" @endif></label>
                                                @unless (($field['required'] ?? false) && ! $upload)
                                                    <button type="button" wire:click="removeFile('{{ $name }}')" @if(!$upload) wire:confirm="Hapus file ini?" @endif class="grid size-8 place-items-center rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600"><x-icon name="trash" class="size-4" /></button>
                                                @endunless
                                            </div>
                                        @else
                                            <label @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false" @drop="dragging = false"
                                                   :class="dragging ? 'border-brand-500 bg-brand-50' : 'border-slate-300 hover:border-brand-400 hover:bg-slate-50'"
                                                   class="relative flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed px-6 py-8 text-center transition">
                                                <x-icon name="upload" class="size-8 text-brand-500" />
                                                <span class="mt-3 text-sm font-semibold text-slate-700">Klik atau seret file ke sini</span>
                                                <span class="mt-1 text-xs text-slate-400">{{ $type === 'image' ? 'JPG, PNG, WEBP' : strtoupper(str_replace(',', ', ', $field['mimes'] ?? 'pdf, doc, docx, xls, xlsx, ppt, pptx, zip')) }} &middot; maks {{ round(($field['max'] ?? ($type === 'image' ? 4096 : 20480)) / 1024) }} MB</span>
                                                <input type="file" wire:model="uploads.{{ $name }}" class="absolute inset-0 cursor-pointer opacity-0" @if($type === 'image') accept="image/*" @endif>
                                            </label>
                                        @endif
                                        <div x-show="uploading" x-cloak class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full bg-brand-500 transition-all" :style="`width: ${progress}%`"></div></div>
                                    </div>
                                    @error("uploads.$name")<p class="form-error">{{ $message }}</p>@enderror
                                    @break
                                @default
                                    <input id="f-{{ $name }}" wire:model="form.{{ $name }}" class="form-input"
                                        type="{{ ['number' => 'number', 'url' => 'url', 'email' => 'email', 'date' => 'date', 'datetime' => 'datetime-local', 'password' => 'password'][$type] ?? 'text' }}"
                                        @if($type === 'password') autocomplete="new-password" @endif>
                            @endswitch

                            @if (isset($field['hint']))<p class="mt-1.5 text-xs text-slate-400">{{ $field['hint'] }}</p>@endif
                            @error("form.$name")<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button type="button" @click="$wire.showForm = false" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save, uploads">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
