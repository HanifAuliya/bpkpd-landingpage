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
        ['label' => 'Berita', 'route' => 'berita.index'],
        ['label' => 'Informasi Publik', 'route' => 'pengumuman.index', 'children' => [
            ['label' => 'Pengumuman', 'route' => 'pengumuman.index', 'icon' => 'megaphone'],
            ['label' => 'Dokumen', 'route' => 'dokumen', 'icon' => 'file'],
            ['label' => 'Galeri Foto', 'route' => 'galeri', 'icon' => 'image'],
        ]],
        ['label' => 'Kontak', 'route' => 'kontak'],
    ];
    $isActive = fn ($item) => isset($item['route']) && ! isset($item['children']) && (request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*'))
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
    <meta property="og:image" content="{{ asset('images/gedung-bpkpd.jpg') }}">
    <meta name="theme-color" content="#0a1220">
    <link rel="icon" href="{{ media(setting('logo'), asset('favicon.svg')) }}">
    <script>
        (function () {
            var saved = null;
            try { saved = localStorage.getItem('theme'); } catch (e) {}
            var dark = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex min-h-screen flex-col font-sans">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-navy-900">Langsung ke konten</a>

    {{-- Top bar resmi --}}
    <div class="bg-navy-950 text-xs text-navy-200 dark:border-b dark:border-navy-800">
        <div class="container-x flex h-10 items-center justify-between gap-4">
            <p class="flex min-w-0 items-center gap-2">
                <x-icon name="landmark" class="size-4 text-gold-400" />
                <span class="truncate">Situs resmi Pemerintah {{ setting('daerah') }}</span>
            </p>
            <div class="flex shrink-0 items-center gap-4">
                <span class="hidden md:inline">{{ now()->translatedFormat('l, d F Y') }}</span>
                @if (setting('email'))
                    <a href="mailto:{{ setting('email') }}" class="hidden items-center gap-1.5 hover:text-white lg:flex"><x-icon name="mail" class="size-3.5" /> {{ setting('email') }}</a>
                @endif
                <span class="hidden items-center gap-1 sm:flex">
                    @foreach ($socials as $social)
                        <a href="{{ $social->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($social->platform) }}" class="grid size-7 place-items-center rounded hover:bg-white/10 hover:text-white">
                            <x-icon :name="$social->platform" class="size-3.5" />
                        </a>
                    @endforeach
                </span>
                <button type="button" x-data @click="$store.theme.toggle()"
                        class="flex items-center gap-1.5 rounded border border-white/15 px-2 py-1 font-semibold text-white transition hover:bg-white/10"
                        :aria-label="$store.theme.dark ? 'Gunakan mode terang' : 'Gunakan mode gelap'">
                    <x-icon name="moon" class="size-3.5" x-show="!$store.theme.dark" />
                    <x-icon name="sun" class="size-3.5 text-gold-300" x-show="$store.theme.dark" x-cloak />
                    <span x-text="$store.theme.dark ? 'Terang' : 'Gelap'">Gelap</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header x-data="{ scrolled: false, open: false, progress: 0, track() { const max = document.documentElement.scrollHeight - innerHeight; this.scrolled = scrollY > 40; this.progress = max > 0 ? Math.min(scrollY / max, 1) : 0 } }"
            x-init="track()" @scroll.window.passive="track()" @resize.window="track()"
            class="sticky top-0 z-50 border-b border-slate-200 bg-white/85 backdrop-blur-xl backdrop-saturate-150 transition-shadow dark:border-navy-800 dark:bg-navy-900/85"
            :class="scrolled && 'shadow-lg shadow-navy-900/5 dark:shadow-black/30'">
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-0.5 origin-left bg-gradient-to-r from-brand-500 via-brand-400 to-gold-400" :style="`transform: scaleX(${progress})`" style="transform: scaleX(0)"></div>
        <div class="container-x flex h-20 items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                <x-logo class="size-12 shrink-0" />
                <span class="min-w-0 leading-tight">
                    <span class="block text-lg font-extrabold tracking-tight text-navy-900 dark:text-white">{{ setting('nama_singkat', 'BPKPD') }}</span>
                    <span class="block truncate text-[11px] font-semibold text-slate-500 sm:text-xs dark:text-navy-300">{{ setting('daerah') }}</span>
                </span>
            </a>

            <nav class="hidden h-full items-stretch lg:flex" aria-label="Menu utama">
                @foreach ($nav as $item)
                    @php $active = $isActive($item); @endphp
                    @if (isset($item['children']))
                        <div x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false" @keydown.escape="show = false" class="relative flex">
                            <button type="button" @click="show = !show" :aria-expanded="show"
                                class="relative flex items-center gap-1 px-3.5 text-sm font-semibold transition xl:px-4 {{ $active ? 'text-brand-700 dark:text-brand-300' : 'text-slate-700 hover:text-brand-700 dark:text-navy-100 dark:hover:text-brand-300' }}">
                                {{ $item['label'] }}
                                <x-icon name="chevron-down" class="size-4 transition" ::class="show && 'rotate-180'" />
                                @if ($active)<span class="absolute inset-x-3 bottom-0 h-[3px] rounded-t bg-gold-500"></span>@endif
                            </button>
                            <div x-show="show" x-cloak x-transition.opacity.duration.150ms class="absolute left-0 top-full w-64 pt-px">
                                <div class="overflow-hidden rounded-b-xl border border-t-2 border-slate-200 border-t-brand-600 bg-white py-2 shadow-xl dark:border-navy-700 dark:border-t-brand-500 dark:bg-navy-900">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ $child['url'] ?? route($child['route']) }}"
                                           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-brand-50 hover:text-brand-800 dark:text-navy-100 dark:hover:bg-navy-800 dark:hover:text-white">
                                            <x-icon :name="$child['icon']" class="size-4 text-brand-600 dark:text-brand-400" />
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}" @if($active) aria-current="page" @endif
                           class="relative flex items-center px-3.5 text-sm font-semibold transition xl:px-4 {{ $active ? 'text-brand-700 dark:text-brand-300' : 'text-slate-700 hover:text-brand-700 dark:text-navy-100 dark:hover:text-brand-300' }}">
                            {{ $item['label'] }}
                            @if ($active)<span class="absolute inset-x-3 bottom-0 h-[3px] rounded-t bg-gold-500"></span>@endif
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('layanan') }}" class="btn-primary hidden xl:inline-flex">
                    <x-icon name="receipt" class="size-4" /> Layanan Pajak
                </a>
                <button type="button" @click="open = !open" class="grid size-11 place-items-center rounded-lg border border-slate-200 text-navy-900 lg:hidden dark:border-navy-700 dark:text-white" :aria-expanded="open" aria-label="Buka menu">
                    <x-icon name="menu" x-show="!open" />
                    <x-icon name="x" x-show="open" x-cloak />
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <div x-show="open" x-cloak x-collapse class="border-t border-slate-200 lg:hidden dark:border-navy-800">
            <nav class="container-x max-h-[70vh] space-y-1 overflow-y-auto py-4">
                @foreach ($nav as $item)
                    @if (isset($item['children']))
                        <p class="px-3 pb-1 pt-3 text-xs font-bold uppercase tracking-[0.18em] text-slate-400 dark:text-navy-400">{{ $item['label'] }}</p>
                        @foreach ($item['children'] as $child)
                            <a href="{{ $child['url'] ?? route($child['route']) }}" @click="open = false" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50 dark:text-navy-100 dark:hover:bg-navy-800">
                                <x-icon :name="$child['icon']" class="size-4 text-brand-600 dark:text-brand-400" /> {{ $child['label'] }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2.5 font-semibold {{ $isActive($item) ? 'bg-brand-50 text-brand-800 dark:bg-navy-800 dark:text-brand-300' : 'text-slate-800 hover:bg-slate-50 dark:text-white dark:hover:bg-navy-800' }}">{{ $item['label'] }}</a>
                    @endif
                @endforeach
            </nav>
        </div>
    </header>

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="relative isolate overflow-hidden border-t-4 border-gold-500 bg-navy-950 text-navy-200">
        <div class="bg-lines absolute inset-0 -z-10"></div>
        <p class="pointer-events-none absolute -bottom-[0.18em] left-1/2 -z-10 -translate-x-1/2 select-none whitespace-nowrap text-[22vw] font-extrabold leading-none tracking-tighter text-white/[0.03] lg:text-[16rem]" aria-hidden="true">{{ setting('nama_singkat', 'BPKPD') }}</p>
        <div class="container-x grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <x-logo class="size-12" />
                    <div class="leading-tight">
                        <p class="text-lg font-extrabold text-white">{{ setting('nama_singkat') }}</p>
                        <p class="text-xs text-navy-300">{{ setting('daerah') }}</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-7">{{ setting('nama_dinas') }} {{ setting('daerah') }}. {{ setting('tagline') }}</p>
                <div class="mt-6 flex gap-2">
                    @foreach ($socials as $social)
                        <a href="{{ $social->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($social->platform) }}"
                           class="grid size-10 place-items-center rounded-lg border border-white/10 text-white transition hover:border-gold-400 hover:bg-gold-400 hover:text-navy-950">
                            <x-icon :name="$social->platform" class="size-4" />
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="lg:col-span-2">
                <p class="text-sm font-bold text-white">Tautan Cepat</p>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ([['Profil', 'profil'], ['Layanan', 'layanan'], ['Berita', 'berita.index'], ['Pengumuman', 'pengumuman.index'], ['Dokumen', 'dokumen'], ['Kontak', 'kontak']] as [$label, $r])
                        <li><a href="{{ route($r) }}" class="transition hover:text-gold-300">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="lg:col-span-3">
                <p class="text-sm font-bold text-white">Alamat Kantor</p>
                <ul class="mt-5 space-y-4 text-sm leading-6">
                    <li class="flex gap-3"><x-icon name="map-pin" class="mt-0.5 size-4 text-gold-400" /> {{ setting('alamat') }}</li>
                    @if (setting('email'))<li class="flex gap-3"><x-icon name="mail" class="mt-0.5 size-4 text-gold-400" /> <a href="mailto:{{ setting('email') }}" class="hover:text-gold-300">{{ setting('email') }}</a></li>@endif
                    @if (setting('telepon'))<li class="flex gap-3"><x-icon name="phone" class="mt-0.5 size-4 text-gold-400" /> {{ setting('telepon') }}</li>@endif
                </ul>
            </div>
            <div class="lg:col-span-3">
                <p class="text-sm font-bold text-white">Jam Pelayanan</p>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach (array_filter(explode("\n", (string) setting('jam_layanan'))) as $line)
                        <li class="flex gap-3"><x-icon name="clock" class="mt-0.5 size-4 text-gold-400" /> {{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pb-24 sm:pb-32 lg:pb-40">
            <div class="container-x flex flex-col items-center justify-between gap-2 py-5 text-xs text-navy-300 sm:flex-row">
                <p>&copy; {{ date('Y') }} {{ setting('nama_dinas') }} {{ setting('daerah') }}</p>
                <p>Pemerintah {{ setting('daerah') }}</p>
            </div>
        </div>
    </footer>

    {{-- Kembali ke atas --}}
    <button x-data="{ show: false }" @scroll.window="show = window.scrollY > 600" x-show="show" x-cloak x-transition.opacity
            @click="window.scrollTo({ top: 0 })" aria-label="Kembali ke atas"
            class="fixed bottom-6 right-6 z-40 grid size-11 place-items-center rounded-lg bg-brand-700 text-white shadow-lg transition hover:bg-brand-800 dark:bg-brand-600">
        <x-icon name="arrow-up" />
    </button>

    @livewireScripts
</body>
</html>
