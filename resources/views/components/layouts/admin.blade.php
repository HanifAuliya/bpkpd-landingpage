@props(['title' => 'Dashboard'])
@php
    $unread = \App\Models\Message::whereNull('read_at')->count();
    $menu = [
        'Utama' => [
            ['Dashboard', 'admin.dashboard', 'dashboard'],
            ['Pesan Masuk', 'admin.messages', 'inbox', $unread],
        ],
        'Konten' => [
            ['Carousel', 'admin.sliders', 'slides'],
            ['Berita', 'admin.posts', 'newspaper'],
            ['Pengumuman', 'admin.announcements', 'megaphone'],
            ['Galeri Foto', 'admin.photos', 'image'],
            ['Dokumen', 'admin.documents', 'file'],
        ],
        'Profil & Layanan' => [
            ['Profil Instansi', 'admin.settings', 'building'],
            ['Data Pegawai', 'admin.employees', 'users'],
            ['Pelayanan', 'admin.services', 'grid'],
            ['Jenis Pelayanan', 'admin.service-types', 'list'],
            ['Media Sosial', 'admin.social-links', 'share'],
            ['Link Terkait', 'admin.related-links', 'link'],
        ],
        'Sistem' => [
            ['Pengguna', 'admin.users', 'shield'],
            ['Akun Saya', 'admin.account', 'user'],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }} | CMS {{ setting('nama_singkat', 'BPKPD') }}</title>
    <link rel="icon" href="{{ media(setting('logo'), asset('favicon.svg')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-100/70 font-sans" x-data="{ sidebar: false }">
    {{-- Sidebar --}}
    <div x-show="sidebar" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-ink/50 backdrop-blur-sm lg:hidden" @click="sidebar = false"></div>
    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col overflow-hidden bg-ink text-white transition-transform duration-300">
        <div class="bg-lines pointer-events-none absolute inset-0"></div>
        <div class="relative flex items-center gap-3 px-6 py-6">
            <x-logo class="size-10" />
            <div>
                <p class="font-extrabold leading-tight">{{ setting('nama_singkat', 'BPKPD') }} <span class="text-gold-400">CMS</span></p>
                <p class="text-[11px] uppercase tracking-[0.18em] text-brand-200/70">Panel Admin</p>
            </div>
        </div>
        <nav class="relative flex-1 space-y-6 overflow-y-auto px-4 pb-6">
            @foreach ($menu as $group => $items)
                <div>
                    <p class="px-3 text-[11px] font-bold uppercase tracking-[0.2em] text-white/35">{{ $group }}</p>
                    <div class="mt-2 space-y-0.5">
                        @foreach ($items as $item)
                            @php $active = request()->routeIs($item[1]); @endphp
                            <a href="{{ route($item[1]) }}" wire:navigate
                               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $active ? 'bg-gradient-to-r from-brand-500/25 to-transparent text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                <span class="grid size-8 place-items-center rounded-lg transition {{ $active ? 'bg-brand-500 text-ink' : 'bg-white/5 group-hover:bg-white/10' }}"><x-icon :name="$item[2]" class="size-4" /></span>
                                <span class="flex-1">{{ $item[0] }}</span>
                                @if (! empty($item[3]))<span class="rounded-full bg-gold-400 px-2 py-0.5 text-[11px] font-bold text-ink">{{ $item[3] }}</span>@endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>
        <div class="relative border-t border-white/10 p-4">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-white/60 hover:bg-white/5 hover:text-white">
                <x-icon name="globe" class="size-4" /> Lihat website <x-icon name="arrow-up-right" class="ml-auto size-3.5" />
            </a>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-30 flex items-center gap-4 border-b border-slate-200/70 bg-white/80 px-4 py-3 backdrop-blur-xl sm:px-8">
            <button @click="sidebar = true" class="grid size-10 place-items-center rounded-xl border border-slate-200 lg:hidden" aria-label="Menu"><x-icon name="menu" /></button>
            <p class="hidden text-sm text-slate-400 sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
            <div class="ml-auto flex items-center gap-3" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 rounded-full py-1 pl-1 pr-3 hover:bg-slate-100">
                    <span class="grid size-9 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="hidden text-left text-sm sm:block"><span class="block font-bold text-slate-800">{{ auth()->user()->name }}</span><span class="block text-xs text-slate-400">{{ auth()->user()->email }}</span></span>
                    <x-icon name="chevron-down" class="size-4 text-slate-400" />
                </button>
                <div x-show="open" x-cloak x-transition class="absolute right-4 top-16 w-52 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl sm:right-8">
                    <a href="{{ route('admin.account') }}" wire:navigate class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50"><x-icon name="user" class="size-4" /> Akun saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm text-rose-600 hover:bg-rose-50"><x-icon name="logout" class="size-4" /> Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-8">
            {{ $slot }}
        </main>
    </div>

    {{-- Toasts --}}
    <div x-data="{ toasts: [] }"
         @toast.window="const t = { id: Date.now(), message: $event.detail.message, type: $event.detail.type ?? 'success' }; toasts.push(t); setTimeout(() => toasts = toasts.filter(x => x.id !== t.id), 3500)"
         class="pointer-events-none fixed bottom-6 right-6 z-[100] space-y-3">
        <template x-for="t in toasts" :key="t.id">
            <div x-transition:enter="transition duration-300" x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                 class="pointer-events-auto flex items-center gap-3 rounded-2xl px-5 py-3.5 text-sm font-semibold text-white shadow-2xl"
                 :class="t.type === 'error' ? 'bg-rose-600' : 'bg-ink'">
                <span class="grid size-6 place-items-center rounded-full" :class="t.type === 'error' ? 'bg-white/20' : 'bg-brand-500 text-ink'"><x-icon name="check" class="size-3.5" /></span>
                <span x-text="t.message"></span>
            </div>
        </template>
    </div>

    @livewireScripts
</body>
</html>
