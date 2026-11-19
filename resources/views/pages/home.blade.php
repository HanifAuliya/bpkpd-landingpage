<x-layouts.public>
    {{-- HERO: foto gedung BPKPD (atau gambar carousel bila diunggah dari CMS) --}}
    <section x-data="slider({{ max($sliders->count(), 1) }})" class="relative isolate flex min-h-[calc(100svh-7.5rem)] flex-col overflow-hidden bg-navy-950 text-white lg:min-h-[680px]">
        @forelse ($sliders as $i => $slide)
            <div x-show="active === {{ $i }}" @if($i) x-cloak @endif
                 x-transition:enter="transition duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0 -z-20 overflow-hidden">
                @if ($slide->image)
                    <img src="{{ media($slide->image) }}" alt="" class="size-full animate-kenburns object-cover">
                @else
                    <img src="{{ asset('images/gedung-bpkpd.jpg') }}" srcset="{{ asset('images/gedung-bpkpd-sm.jpg') }} 1200w, {{ asset('images/gedung-bpkpd.jpg') }} 2400w" sizes="100vw"
                         alt="Gedung {{ setting('nama_dinas') }}" class="size-full animate-kenburns object-cover object-[62%_center]" @if($i === 0) fetchpriority="high" @endif>
                @endif
            </div>
        @empty
            <img src="{{ asset('images/gedung-bpkpd.jpg') }}" alt="Gedung {{ setting('nama_dinas') }}" class="absolute inset-0 -z-20 size-full animate-kenburns object-cover object-[62%_center]">
        @endforelse
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/85 to-navy-950/20"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-64 bg-gradient-to-t from-navy-950 via-navy-950/60 to-transparent"></div>
        <div class="bg-lines absolute inset-0 -z-10 [mask-image:linear-gradient(90deg,black,transparent_60%)]"></div>

        {{-- Label vertikal di sisi kanan --}}
        <p class="absolute right-8 top-1/2 hidden -translate-y-1/2 rotate-90 text-[11px] font-bold uppercase tracking-[0.5em] text-white/40 xl:block">Barabai &middot; Kalimantan Selatan</p>

        <div class="container-x flex flex-1 items-center pb-10 pt-14 sm:pt-16 lg:pt-20">
            <div class="max-w-4xl">
                <p class="glass inline-flex items-center gap-2.5 rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-[0.18em] text-gold-300">
                    <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-gold-400 opacity-60"></span><span class="relative inline-flex size-2 rounded-full bg-gold-400"></span></span>
                    Website Resmi Pemerintah Daerah
                </p>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-5xl xl:text-6xl">{{ setting('nama_dinas') }}</h1>
                <div class="mt-5 flex items-center gap-4">
                    <span class="h-px w-12 bg-gold-400"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-gold-300 sm:text-base">{{ setting('daerah') }}</p>
                </div>

                <div class="mt-7 grid max-w-xl">
                    @forelse ($sliders as $i => $slide)
                        <div x-show="active === {{ $i }}" @if($i) x-cloak @endif class="[grid-area:1/1]"
                             x-transition:enter="transition duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <p class="text-xl font-bold text-white">{{ $slide->title }}</p>
                            <p class="mt-2 text-lg leading-8 text-navy-200">{{ $slide->subtitle }}</p>
                            @if ($slide->button_text)
                                <div class="mt-8 flex flex-wrap gap-3">
                                    <a href="{{ $slide->button_url ?: route('profil') }}" class="btn-gold !px-6 !py-3.5">{{ $slide->button_text }} <x-icon name="arrow-right" class="size-4" /></a>
                                    <a href="{{ route('kontak') }}" class="btn-ghost !px-6 !py-3.5 backdrop-blur">Hubungi Kami</a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-lg leading-8 text-navy-200">{{ setting('tagline') }}</p>
                    @endforelse
                </div>

                @if ($sliders->count() > 1)
                    <div class="mt-8 flex items-center gap-4">
                        <span class="font-mono text-sm text-white/60"><span class="text-white" x-text="String(active + 1).padStart(2, '0')">01</span> / {{ str_pad($sliders->count(), 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="flex gap-1.5">
                            @foreach ($sliders as $i => $slide)
                                <button @click="go({{ $i }})" class="h-1 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'w-10 bg-gold-400' : 'w-5 bg-white/30 hover:bg-white/50'" aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="flex gap-2">
                            <button @click="prev(); play()" class="grid size-10 place-items-center rounded-full border border-white/25 transition hover:bg-white hover:text-navy-950" aria-label="Sebelumnya"><x-icon name="chevron-left" class="size-4" /></button>
                            <button @click="next(); play()" class="grid size-10 place-items-center rounded-full border border-white/25 transition hover:bg-white hover:text-navy-950" aria-label="Berikutnya"><x-icon name="chevron-right" class="size-4" /></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Panel info kantor --}}
        @php
            $heroInfo = array_filter([
                ['clock', 'Jam Pelayanan', collect(explode("\n", (string) setting('jam_layanan')))->filter()->first(), route('kontak')],
                ['map-pin', 'Alamat Kantor', \Illuminate\Support\Str::before((string) setting('alamat'), ',').', Barabai', route('kontak')],
                ['grid', 'Layanan Online', $services->count().' layanan, akses 24 jam', route('layanan')],
                ['mail', 'Email', setting('email'), 'mailto:'.setting('email')],
            ], fn (array $info): bool => filled($info[2]));
        @endphp
        <div class="container-x pb-8 sm:pb-10">
            <div class="glass grid gap-px overflow-hidden rounded-2xl !bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($heroInfo as [$icon, $label, $value, $href])
                    <a href="{{ $href }}" class="group flex items-center gap-4 bg-navy-950/50 p-5 transition hover:bg-navy-950/25">
                        <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-gold-400/15 text-gold-300 transition group-hover:bg-gold-400 group-hover:text-navy-950"><x-icon :name="$icon" class="size-5" /></span>
                        <span class="min-w-0">
                            <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-white/50">{{ $label }}</span>
                            <span class="mt-0.5 block text-sm font-semibold leading-snug text-white">{{ $value }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pengumuman berjalan --}}
    @if ($announcements->isNotEmpty())
        <div class="border-b border-slate-200 bg-white dark:border-navy-800 dark:bg-navy-900">
            <div class="container-x flex items-stretch">
                <a href="{{ route('pengumuman.index') }}" class="flex shrink-0 items-center gap-2 bg-gold-400 px-4 text-xs font-extrabold uppercase tracking-[0.15em] text-navy-950">
                    <x-icon name="megaphone" class="size-4" /> <span class="hidden sm:inline">Pengumuman</span>
                </a>
                <div class="group relative flex flex-1 overflow-hidden py-3.5 [mask-image:linear-gradient(90deg,transparent,black_4%,black_96%,transparent)]">
                    <div class="flex shrink-0 animate-marquee gap-12 pr-12 group-hover:[animation-play-state:paused]">
                        @foreach ($announcements->concat($announcements) as $item)
                            <a href="{{ route('pengumuman.show', $item) }}" class="shrink-0 whitespace-nowrap text-sm font-medium text-slate-700 hover:text-brand-700 dark:text-navy-100 dark:hover:text-brand-300">
                                <span class="text-slate-400 dark:text-navy-400">{{ $item->published_at?->translatedFormat('d M Y') }} &middot;</span> {{ $item->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- TENTANG & SAMBUTAN --}}
    <section id="tentang" class="relative isolate scroll-mt-24 py-20 sm:py-28">
        <div class="bg-dots absolute inset-0 -z-10 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_55%)]"></div>
        <div class="container-x grid items-start gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-7">
                <x-section-heading number="01" eyebrow="Tentang Kami" title="Mengelola keuangan dan pendapatan daerah secara <span class='text-brand-700 dark:text-brand-300'>transparan</span> dan akuntabel" />
                <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-navy-300" data-reveal="up">{{ setting('deskripsi') }}</p>
                <dl class="mt-12 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-4" data-reveal="up">
                    @foreach ([
                        ['Layanan Online', $stats['layanan']],
                        ['Pegawai', $stats['pegawai']],
                        ['Berita & Info', $stats['berita']],
                        ['Dokumen Publik', $stats['dokumen']],
                    ] as [$label, $value])
                        <div class="border-l-2 border-gold-400 pl-4">
                            <dd class="text-4xl font-extrabold tracking-tight text-navy-900 sm:text-5xl dark:text-white" x-data="counter({{ $value }})" x-text="value">{{ $value }}</dd>
                            <dt class="mt-1.5 text-xs font-bold uppercase tracking-[0.15em] text-slate-500 dark:text-navy-400">{{ $label }}</dt>
                        </div>
                    @endforeach
                </dl>
                <div class="mt-12 flex flex-wrap gap-3" data-reveal="up">
                    <a href="{{ route('profil') }}" class="btn-primary !px-6 !py-3">Profil lengkap <x-icon name="arrow-right" class="size-4" /></a>
                    <a href="{{ route('profil.struktur') }}" class="btn-outline !px-6 !py-3">Struktur organisasi</a>
                </div>
            </div>

            {{-- Sambutan kepala --}}
            <div class="relative lg:col-span-5 lg:mt-4" data-reveal="right">
                <div class="absolute -inset-4 -z-10 rotate-3 rounded-[2.5rem] bg-gradient-to-br from-brand-200 to-gold-300/60 dark:from-brand-900 dark:to-gold-500/25"></div>
                <figure class="overflow-hidden rounded-[2rem] bg-ink text-white shadow-2xl dark:bg-navy-900 dark:ring-1 dark:ring-white/10">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-brand-700 to-ink">
                        @if (setting('kepala_foto'))
                            <img src="{{ media(setting('kepala_foto')) }}" alt="{{ setting('kepala_nama') }}" class="size-full object-cover object-top">
                        @else
                            <div class="bg-lines absolute inset-0"></div>
                            <x-icon name="user" class="absolute left-1/2 top-1/2 size-28 -translate-x-1/2 -translate-y-1/2 text-white/20" />
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/20 to-transparent"></div>
                        <figcaption class="absolute bottom-0 p-7">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-300">Sambutan Kepala Badan</p>
                            <p class="mt-1 text-2xl font-extrabold">{{ setting('kepala_nama') }}</p>
                            @if (setting('kepala_jabatan'))<p class="mt-1 text-sm text-white/70">{{ setting('kepala_jabatan') }}</p>@endif
                        </figcaption>
                    </div>
                    <blockquote class="relative p-7">
                        <x-icon name="quote" class="absolute right-6 top-6 size-10 text-white/10" />
                        <p class="leading-7 text-white/75">{{ setting('sambutan') }}</p>
                    </blockquote>
                </figure>
            </div>
        </div>
    </section>

    {{-- LAYANAN ONLINE --}}
    <section class="relative overflow-hidden bg-slate-50 py-20 sm:py-28 dark:bg-navy-900/40">
        <div class="container-x">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading number="02" eyebrow="Layanan Publik" title="Layanan online untuk wajib pajak" subtitle="Urus pajak daerah, BPHTB, dan PBB-P2 dari mana saja tanpa harus antre." />
                <a href="{{ route('layanan') }}" class="btn-outline" data-reveal="up">Persyaratan layanan <x-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $i => $service)
                    <x-service-card :service="$service" :delay="$i * 90" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- BERITA & PENGUMUMAN --}}
    <section class="isolate py-20 sm:py-28">
        <div class="container-x">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading number="03" eyebrow="Kabar Terbaru" title="Berita BPKPD" subtitle="Kegiatan dan informasi seputar keuangan, pajak, dan pendapatan daerah Hulu Sungai Tengah." />
                <a href="{{ route('berita.index') }}" class="btn-outline" data-reveal="up">Indeks berita <x-icon name="arrow-right" class="size-4" /></a>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-12">
                @php $lead = $posts->first(); @endphp
                @if ($lead)
                    {{-- Berita utama: kartu gelap dengan bingkai miring, seperti kartu sambutan --}}
                    <article class="group relative lg:col-span-5" data-reveal="up">
                        <div class="absolute -inset-3 -z-10 -rotate-2 rounded-[2.5rem] bg-gradient-to-br from-brand-200 to-gold-300/60 dark:from-brand-900 dark:to-gold-500/25"></div>
                        <a href="{{ route('berita.show', $lead) }}" class="flex h-full flex-col overflow-hidden rounded-[2rem] bg-ink text-white shadow-2xl dark:bg-navy-900 dark:ring-1 dark:ring-white/10">
                            <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-brand-700 to-ink">
                                <x-post-thumb :post="$lead" class="transition duration-700 group-hover:scale-105" />
                                <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/30 to-transparent dark:from-navy-900"></div>
                                <div class="absolute bottom-0 p-7">
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-300">Berita Utama &middot; {{ $lead->published_at?->translatedFormat('d F Y') }}</p>
                                    <h3 class="mt-2 text-2xl font-extrabold leading-snug transition group-hover:text-gold-300">{{ $lead->title }}</h3>
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col p-7 pt-5">
                                <p class="line-clamp-3 leading-7 text-white/75">{{ $lead->summary(240) }}</p>
                                <span class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-gold-300">Baca selengkapnya <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" /></span>
                            </div>
                        </a>
                    </article>
                    <div class="grid content-start gap-4 lg:col-span-4">
                        @foreach ($posts->skip(1) as $i => $post)
                            <x-post-item :post="$post" :delay="$i * 80" />
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 lg:col-span-9 dark:text-navy-300">Belum ada berita.</p>
                @endif

                <aside class="lg:col-span-3" data-reveal="up" style="--delay:160ms">
                    <div class="h-full rounded-3xl bg-gradient-to-br from-brand-700 to-ink p-7 text-white shadow-2xl shadow-brand-900/20 dark:ring-1 dark:ring-white/10">
                        <div class="flex items-center gap-3">
                            <span class="grid size-11 place-items-center rounded-xl bg-gold-400 text-ink"><x-icon name="megaphone" /></span>
                            <h3 class="text-xl font-extrabold">Pengumuman</h3>
                        </div>
                        <ul class="mt-5 divide-y divide-white/10">
                            @forelse ($announcements as $item)
                                <li>
                                    <a href="{{ route('pengumuman.show', $item) }}" class="group block py-4">
                                        <p class="text-xs font-semibold text-gold-300">{{ $item->published_at?->translatedFormat('d F Y') }}</p>
                                        <p class="mt-1 font-semibold leading-snug transition group-hover:text-gold-300">{{ $item->title }}</p>
                                    </a>
                                </li>
                            @empty
                                <li class="py-4 text-white/60">Belum ada pengumuman.</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('pengumuman.index') }}" class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-gold-300">Lihat semua <x-icon name="arrow-right" class="size-4" /></a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <section class="relative isolate overflow-hidden bg-navy-900 py-24 text-white sm:py-32 dark:bg-navy-950">
        <img src="{{ asset('images/gedung-bpkpd-sm.jpg') }}" alt="" loading="lazy" class="absolute inset-0 -z-20 size-full object-cover opacity-10 grayscale">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-navy-900 via-navy-900/90 to-navy-900 dark:from-navy-950 dark:via-navy-950/90 dark:to-navy-950"></div>
        <div class="bg-lines absolute inset-0 -z-10"></div>
        <div class="container-x">
            <div class="mx-auto max-w-4xl text-center" data-reveal="up">
                <p class="inline-flex items-center gap-3 text-xs font-bold uppercase tracking-[0.25em] text-gold-300">
                    <span class="text-gold-400">04</span><span class="text-white/30">/</span>Visi Kami
                </p>
                <div class="relative mt-8">
                    <span class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 select-none font-serif text-[9rem] leading-none text-gold-400/15" aria-hidden="true">&ldquo;</span>
                    <blockquote class="relative text-3xl font-extrabold leading-tight tracking-tight sm:text-5xl">{{ setting('visi') }}</blockquote>
                </div>
            </div>

            <div class="mx-auto mt-16 grid max-w-5xl gap-5 md:grid-cols-3">
                @foreach (array_values(array_filter(explode("\n", (string) setting('misi')))) as $i => $misi)
                    <div class="glass group rounded-3xl p-7 transition duration-500 hover:-translate-y-1 hover:border-gold-400/40 hover:bg-white/10" data-reveal="up" style="--delay: {{ 120 + $i * 100 }}ms">
                        <div class="flex items-center justify-between">
                            <span class="text-outline text-5xl font-extrabold">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/40">Misi</span>
                        </div>
                        <p class="mt-5 leading-7 text-navy-100">{{ $misi }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center" data-reveal="up">
                <a href="{{ route('profil') }}#visi-misi" class="btn-ghost !px-6 !py-3">Tugas pokok & fungsi <x-icon name="arrow-right" class="size-4" /></a>
            </div>
        </div>
    </section>

    {{-- GALERI --}}
    @if ($photos->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="container-x">
                <div class="flex flex-wrap items-end justify-between gap-6">
                    <x-section-heading number="05" eyebrow="Galeri" title="Dokumentasi kegiatan" />
                    <a href="{{ route('galeri') }}" class="btn-outline">Lihat galeri <x-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="mt-10 grid auto-rows-[170px] grid-cols-2 gap-3 md:grid-cols-4">
                    @foreach ($photos as $i => $photo)
                        <a href="{{ route('galeri') }}" data-reveal="zoom" style="--delay: {{ $i * 60 }}ms"
                           class="group relative overflow-hidden rounded-xl {{ $i === 0 ? 'col-span-2 row-span-2' : '' }}">
                            <img src="{{ media($photo->image) }}" alt="{{ $photo->title }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950/85 to-transparent p-4 pt-10 opacity-0 transition group-hover:opacity-100">
                                <p class="text-sm font-semibold text-white">{{ $photo->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- TAUTAN TERKAIT --}}
    @if ($relatedLinks->isNotEmpty())
        <section class="border-t border-slate-200 py-16 dark:border-navy-800 {{ $photos->isEmpty() ? '' : 'bg-slate-50 dark:bg-navy-900/40' }}">
            <div class="container-x">
                <p class="eyebrow">Tautan Terkait</p>
                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="card group flex items-center gap-3 px-4 py-3.5 transition hover:border-brand-300 dark:hover:border-brand-700">
                            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-slate-100 text-navy-700 transition group-hover:bg-brand-700 group-hover:text-white dark:bg-navy-800 dark:text-navy-200"><x-icon name="globe" class="size-4" /></span>
                            <span class="min-w-0 flex-1 truncate text-sm font-semibold text-navy-900 dark:text-white">{{ $link->name }}</span>
                            <x-icon name="external" class="size-4 text-slate-400" />
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- KONTAK --}}
    <section class="py-20 sm:py-24">
        <div class="container-x">
            <div class="relative isolate overflow-hidden rounded-[2.5rem] bg-navy-950 px-6 py-14 text-white sm:px-12 lg:px-16" data-reveal="zoom">
                <img src="{{ asset('images/gedung-bpkpd-sm.jpg') }}" alt="" loading="lazy" class="absolute inset-0 -z-20 size-full object-cover object-[70%_center] opacity-40">
                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/90 to-brand-900/60"></div>
                <div class="bg-lines absolute inset-0 -z-10"></div>
                <div class="grid items-center gap-10 lg:grid-cols-12">
                    <div class="lg:col-span-6">
                        <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-gold-300"><span class="h-px w-8 bg-gold-400"></span>Hubungi Kami</p>
                        <h2 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">Ada pertanyaan seputar pajak & retribusi daerah?</h2>
                        <p class="mt-4 text-lg leading-8 text-navy-200">Tim kami siap membantu. Kirim pesan secara online atau kunjungi langsung kantor BPKPD di Barabai.</p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('kontak') }}" class="btn-gold !px-6 !py-3.5">Kirim Pesan <x-icon name="send" class="size-4" /></a>
                            <a href="{{ route('layanan') }}" class="btn-ghost !px-6 !py-3.5 backdrop-blur">Lihat Layanan</a>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2 lg:col-span-6">
                        @foreach (array_filter([
                            ['map-pin', 'Alamat', setting('alamat')],
                            ['clock', 'Jam Pelayanan', setting('jam_layanan')],
                            ['mail', 'Email', setting('email')],
                            ['phone', 'Telepon', setting('telepon')],
                        ], fn (array $item): bool => filled($item[2])) as [$icon, $label, $value])
                            <div class="glass rounded-2xl p-5 {{ $icon === 'map-pin' ? 'sm:col-span-2' : '' }}">
                                <p class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-gold-300"><x-icon :name="$icon" class="size-4" /> {{ $label }}</p>
                                <p class="mt-2 text-sm leading-6 text-white/85">{!! nl2br(e($value)) !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
