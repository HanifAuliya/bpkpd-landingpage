@props(['title' => null, 'description' => null, 'transparent' => false])
@php
    $siteName = setting('nama_singkat', 'BPKPD').' '.setting('daerah', 'Kabupaten Hulu Sungai Tengah');
    $pageTitle = $title ? $title.' | '.$siteName : setting('nama_dinas').' | '.setting('daerah');
    $nav = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Profil', 'route' => 'profil', 'children' => [
            ['label' => 'Tentang & Tugas Fungsi', 'route' => 'profil', 'icon' => 'building'],
            ['label' => 'Visi & Misi', 'url' => route('profil').'#visi-misi', 'icon' => 'target'],
            ['label' => 'Struktur Organisasi', 'route' => 'profil.struktur', 'icon' => 'chart'],
            ['label' => 'Data Pegawai', 'route' => 'profil.pegawai', 'icon' => 'users'],
        ]],
        ['label' => 'Layanan', 'route' => 'layanan'],
        ['label' => 'Informasi', 'route' => 'berita.index', 'children' => [
            ['label' => 'Berita', 'route' => 'berita.index', 'icon' => 'newspaper'],
            ['label' => 'Pengumuman', 'route' => 'pengumuman.index', 'icon' => 'megaphone'],
            ['label' => 'Galeri Foto', 'route' => 'galeri', 'icon' => 'image'],
            ['label' => 'Dokumen', 'route' => 'dokumen', 'icon' => 'file'],
        ]],
        ['label' => 'Kontak', 'route' => 'kontak'],
    ];
    $isActive = fn ($item) => isset($item['route']) && (request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*'))
        || collect($item['children'] ?? [])->contains(fn ($c) => isset($c['route']) && request()->routeIs($c['route'], $c['route'].'.*'));
    $socials = \App\Models\SocialLink::orderBy('sort_order')->get();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description ?? setting('tagline') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description ?? setting('tagline') }}">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#04130e">
    <link rel="icon" href="{{ media(setting('logo'), asset('favicon.svg')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-white font-sans">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Langsung ke konten</a>

    {{-- Header --}}
    <header x-data="{ scrolled: false, open: false }"
            x-init="scrolled = window.scrollY > 24"
            @scroll.window="scrolled = window.scrollY > 24"
            class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
            :class="scrolled || open ? 'bg-ink/85 shadow-2xl shadow-black/20 backdrop-blur-xl py-3' : '{{ $transparent ? 'bg-transparent py-5' : 'bg-ink py-4' }}'">
        <div class="container-x flex items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <x-logo class="size-11 transition duration-500 group-hover:rotate-[8deg] group-hover:scale-105" />
                <span class="leading-tight">
                    <span class="block text-lg font-extrabold tracking-tight text-white">{{ setting('nama_singkat', 'BPKPD') }}<span class="text-gold-400">.</span></span>
                    <span class="hidden text-[11px] font-medium uppercase tracking-[0.2em] text-brand-200/80 sm:block">{{ setting('daerah') }}</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Menu utama">
                @foreach ($nav as $item)
                    @if (isset($item['children']))
                        <div x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false" class="relative">
                            <button type="button" @click="show = !show" :aria-expanded="show"
                                class="flex items-center gap-1 rounded-full px-4 py-2 text-sm font-semibold transition {{ $isActive($item) ? 'text-gold-300' : 'text-white/80 hover:text-white' }}">
                                {{ $item['label'] }}
                                <x-icon name="chevron-down" class="size-4 transition" ::class="show && 'rotate-180'" />
                            </button>
                            <div x-show="show" x-cloak
                                 x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                 class="absolute left-1/2 top-full w-72 -translate-x-1/2 pt-3">
                                <div class="overflow-hidden rounded-2xl border border-white/10 bg-ink/95 p-2 shadow-2xl backdrop-blur-xl">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ $child['url'] ?? route($child['route']) }}"
                                           class="group/item flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/80 transition hover:bg-white/10 hover:text-white">
                                            <span class="grid size-9 place-items-center rounded-lg bg-brand-500/15 text-brand-300 transition group-hover/item:bg-gold-400 group-hover/item:text-ink">
                                                <x-icon :name="$child['icon']" class="size-4" />
                                            </span>
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}"
                           class="relative rounded-full px-4 py-2 text-sm font-semibold transition {{ $isActive($item) ? 'text-gold-300' : 'text-white/80 hover:text-white' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('layanan') }}" class="btn-gold hidden !py-2 sm:inline-flex">
                    Layanan Online <x-icon name="arrow-up-right" class="size-4" />
                </a>
                <button type="button" @click="open = !open" class="grid size-11 place-items-center rounded-full border border-white/15 text-white lg:hidden" :aria-expanded="open" aria-label="Buka menu">
                    <x-icon name="menu" x-show="!open" />
                    <x-icon name="x" x-show="open" x-cloak />
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-cloak x-collapse class="lg:hidden">
            <nav class="container-x mt-4 space-y-1 border-t border-white/10 pb-6 pt-4">
                @foreach ($nav as $item)
                    @if (isset($item['children']))
                        <p class="px-3 pt-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-300/70">{{ $item['label'] }}</p>
                        @foreach ($item['children'] as $child)
                            <a href="{{ $child['url'] ?? route($child['route']) }}" @click="open = false" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-white/85 hover:bg-white/10">
                                <x-icon :name="$child['icon']" class="size-4 text-brand-300" /> {{ $child['label'] }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ route($item['route']) }}" class="block rounded-xl px-3 py-2.5 font-semibold {{ $isActive($item) ? 'bg-white/10 text-gold-300' : 'text-white/90 hover:bg-white/10' }}">{{ $item['label'] }}</a>
                    @endif
                @endforeach
            </nav>
        </div>
    </header>

    <main id="konten">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="relative overflow-hidden bg-ink text-white/70">
        <div class="bg-grid absolute inset-0 opacity-60"></div>
        <div class="absolute -right-32 -top-32 size-96 rounded-full bg-brand-600/20 blur-3xl"></div>
        <div class="container-x relative grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <x-logo class="size-12" />
                    <div>
                        <p class="text-lg font-extrabold text-white">{{ setting('nama_singkat') }}<span class="text-gold-400">.</span></p>
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-200/70">{{ setting('daerah') }}</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-7">{{ setting('nama_dinas') }}. {{ setting('tagline') }}</p>
                <div class="mt-6 flex gap-2">
                    @foreach ($socials as $social)
                        <a href="{{ $social->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($social->platform) }}"
                           class="grid size-10 place-items-center rounded-full border border-white/10 bg-white/5 text-white transition hover:-translate-y-1 hover:border-gold-400 hover:bg-gold-400 hover:text-ink">
                            <x-icon :name="$social->platform" class="size-4" />
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="lg:col-span-2">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-white">Jelajahi</p>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ([['Profil', 'profil'], ['Layanan', 'layanan'], ['Berita', 'berita.index'], ['Pengumuman', 'pengumuman.index'], ['Dokumen', 'dokumen'], ['Kontak', 'kontak']] as [$label, $r])
                        <li><a href="{{ route($r) }}" class="transition hover:text-gold-300">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="lg:col-span-3">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-white">Hubungi Kami</p>
                <ul class="mt-5 space-y-4 text-sm">
                    <li class="flex gap-3"><x-icon name="map-pin" class="mt-0.5 size-4 text-gold-400" /> {{ setting('alamat') }}</li>
                    @if (setting('email'))<li class="flex gap-3"><x-icon name="mail" class="mt-0.5 size-4 text-gold-400" /> <a href="mailto:{{ setting('email') }}" class="hover:text-gold-300">{{ setting('email') }}</a></li>@endif
                    @if (setting('telepon'))<li class="flex gap-3"><x-icon name="phone" class="mt-0.5 size-4 text-gold-400" /> {{ setting('telepon') }}</li>@endif
                </ul>
            </div>
            <div class="lg:col-span-3">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-white">Jam Pelayanan</p>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach (array_filter(explode("\n", (string) setting('jam_layanan'))) as $line)
                        <li class="flex gap-3"><x-icon name="clock" class="mt-0.5 size-4 text-gold-400" /> {{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="relative border-t border-white/10">
            <div class="container-x flex flex-col items-center justify-between gap-3 py-6 text-xs sm:flex-row">
                <p>&copy; {{ date('Y') }} {{ setting('nama_dinas') }} {{ setting('daerah') }}.</p>
                <p>Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    {{-- Back to top --}}
    <button x-data="{ show: false }" @scroll.window="show = window.scrollY > 600" x-show="show" x-cloak x-transition
            @click="window.scrollTo({ top: 0 })" aria-label="Kembali ke atas"
            class="fixed bottom-6 right-6 z-40 grid size-12 place-items-center rounded-full bg-gold-400 text-ink shadow-xl shadow-gold-500/30 transition hover:-translate-y-1">
        <x-icon name="arrow-up" />
    </button>

    @livewireScripts
</body>
</html>
