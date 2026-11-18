<x-layouts.public :transparent="true">
    {{-- HERO --}}
    <section x-data="slider({{ max($sliders->count(), 1) }})" class="relative isolate flex min-h-[100svh] items-center overflow-hidden bg-ink text-white">
        {{-- Background images per slide --}}
        @foreach ($sliders as $i => $slide)
            @if ($slide->image)
                <div x-show="active === {{ $i }}" x-transition:enter="transition duration-[1500ms]" x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="absolute inset-0 -z-20" @if($i) x-cloak @endif>
                    <img src="{{ media($slide->image) }}" alt="" class="size-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/85 to-ink/40"></div>
                </div>
            @endif
        @endforeach

        <div class="bg-grid absolute inset-0 -z-10 [mask-image:radial-gradient(ellipse_at_center,black,transparent_80%)]"></div>
        <div class="absolute -left-40 top-1/4 -z-10 size-[34rem] animate-blob rounded-full bg-brand-600/35 blur-3xl"></div>
        <div class="absolute -right-32 top-10 -z-10 size-[28rem] animate-blob rounded-full bg-gold-500/20 blur-3xl [animation-delay:-5s]"></div>
        <div class="absolute bottom-0 left-1/3 -z-10 size-[24rem] animate-blob rounded-full bg-brand-400/20 blur-3xl [animation-delay:-10s]"></div>

        <div class="container-x grid grid-cols-1 items-center gap-14 pb-24 pt-36 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold text-brand-100 backdrop-blur" data-reveal="up">
                    <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-brand-400 opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-brand-400"></span></span>
                    Website Resmi Pemerintah {{ setting('daerah') }}
                </div>

                <div class="relative mt-6 min-h-[15rem] sm:min-h-[13rem]">
                    @forelse ($sliders as $i => $slide)
                        <div x-show="active === {{ $i }}" @if($i) x-cloak @endif
                             x-transition:enter="transition duration-700 delay-200 ease-out" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-300 absolute inset-x-0 top-0" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-4">
                            <h1 class="text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                @if ($i === 0)
                                    {{ $slide->title }} di <span class="text-gradient">{{ setting('nama_singkat') }}</span>
                                @else
                                    {{ $slide->title }}
                                @endif
                            </h1>
                            <p class="mt-6 max-w-xl text-lg leading-8 text-white/70">{{ $slide->subtitle }}</p>
                            @if ($slide->button_text)
                                <div class="mt-9 flex flex-wrap gap-3">
                                    <a href="{{ $slide->button_url ?: '#tentang' }}" class="btn-gold !px-7 !py-3.5">{{ $slide->button_text }} <x-icon name="arrow-right" class="size-4" /></a>
                                    <a href="{{ route('kontak') }}" class="btn-ghost !px-7 !py-3.5">Hubungi Kami</a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <h1 class="text-5xl font-extrabold leading-tight sm:text-7xl">{{ setting('nama_dinas') }}</h1>
                    @endforelse
                </div>

                @if ($sliders->count() > 1)
                    <div class="mt-12 flex items-center gap-4" data-reveal="up" style="--delay:300ms">
                        <button @click="prev(); play()" class="grid size-11 place-items-center rounded-full border border-white/15 transition hover:bg-white hover:text-ink" aria-label="Sebelumnya"><x-icon name="chevron-left" /></button>
                        <div class="flex gap-2">
                            @foreach ($sliders as $i => $slide)
                                <button @click="go({{ $i }})" class="h-1.5 overflow-hidden rounded-full bg-white/20 transition-all duration-500" :class="active === {{ $i }} ? 'w-12' : 'w-6'" aria-label="Slide {{ $i + 1 }}">
                                    <span class="block h-full bg-gold-400 transition-all" :class="active === {{ $i }} ? 'w-full duration-[6500ms] ease-linear' : 'w-0 duration-0'"></span>
                                </button>
                            @endforeach
                        </div>
                        <button @click="next(); play()" class="grid size-11 place-items-center rounded-full border border-white/15 transition hover:bg-white hover:text-ink" aria-label="Berikutnya"><x-icon name="chevron-right" /></button>
                    </div>
                @endif
            </div>

            {{-- Floating quick services card --}}
            <div class="lg:col-span-5" data-reveal="left" style="--delay:250ms">
                <div class="relative animate-float">
                    <div class="absolute -inset-1 rounded-[2rem] bg-gradient-to-br from-brand-400/60 via-transparent to-gold-400/50 blur-sm"></div>
                    <div class="relative rounded-[2rem] border border-white/10 bg-white/[0.06] p-6 shadow-2xl backdrop-blur-2xl sm:p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-300">Layanan Online</p>
                                <p class="mt-1 text-xl font-bold">Akses cepat 24 jam</p>
                            </div>
                            <span class="grid size-12 place-items-center rounded-2xl bg-gold-400 text-ink"><x-icon name="sparkles" /></span>
                        </div>
                        <div class="mt-6 space-y-2.5">
                            @foreach ($services->take(4) as $service)
                                <a href="{{ $service->url }}" target="_blank" rel="noopener"
                                   class="group flex items-center gap-4 rounded-2xl border border-white/5 bg-white/5 p-3.5 transition duration-300 hover:border-brand-400/40 hover:bg-white/10">
                                    <span class="grid size-11 place-items-center rounded-xl bg-brand-500/20 text-brand-300 transition group-hover:bg-brand-400 group-hover:text-ink">
                                        <x-icon :name="$service->icon" />
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-bold">{{ $service->title }}</span>
                                        <span class="block truncate text-xs text-white/55">{{ $service->description }}</span>
                                    </span>
                                    <x-icon name="arrow-up-right" class="size-4 text-white/40 transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-gold-300" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="#tentang" class="absolute bottom-8 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-white/50 md:flex">
            Gulir
            <span class="flex h-9 w-5 justify-center rounded-full border-2 border-white/30 pt-1.5"><span class="size-1.5 animate-scroll-dot rounded-full bg-white"></span></span>
        </a>
    </section>

    {{-- STATS --}}
    <section class="relative z-10 -mt-12">
        <div class="container-x">
            <div class="grid grid-cols-2 gap-px overflow-hidden rounded-3xl border border-slate-200 bg-slate-200 shadow-2xl shadow-brand-900/10 lg:grid-cols-4" data-reveal="up">
                @foreach ([
                    ['Layanan Online', $stats['layanan'], 'grid'],
                    ['Pegawai', $stats['pegawai'], 'users'],
                    ['Berita & Informasi', $stats['berita'], 'newspaper'],
                    ['Dokumen Publik', $stats['dokumen'], 'file'],
                ] as [$label, $value, $icon])
                    <div class="group flex items-center gap-4 bg-white p-6 transition hover:bg-brand-50 sm:p-8">
                        <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white"><x-icon :name="$icon" /></span>
                        <div>
                            <p class="text-3xl font-extrabold text-slate-900" x-data="counter({{ $value }})" x-text="value">{{ $value }}</p>
                            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TENTANG --}}
    <section id="tentang" class="relative scroll-mt-24 py-24 sm:py-32">
        <div class="bg-grid-dark absolute inset-x-0 top-0 h-full [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_60%)]"></div>
        <div class="container-x relative grid items-center gap-16 lg:grid-cols-2">
            <div>
                <x-section-heading eyebrow="Tentang Kami" :title="'Melayani dengan <span class=\'text-brand-600\'>transparan</span> dan akuntabel'" />
                <p class="mt-6 text-lg leading-8 text-slate-600" data-reveal="up" style="--delay:100ms">{{ setting('deskripsi') }}</p>
                <div class="mt-8 grid gap-4 sm:grid-cols-2" data-reveal="up" style="--delay:180ms">
                    @foreach ([['shield', 'Kredibel', 'Pengelolaan sesuai aturan'], ['chart', 'Transparan', 'Informasi terbuka untuk publik'], ['wallet', 'Pendapatan Daerah', 'Pajak & retribusi daerah'], ['sparkles', 'Digital', 'Layanan berbasis teknologi']] as [$icon, $t, $d])
                        <div class="flex gap-3">
                            <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-600 text-white"><x-icon :name="$icon" class="size-4" /></span>
                            <div><p class="font-bold text-slate-900">{{ $t }}</p><p class="text-sm text-slate-500">{{ $d }}</p></div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('profil') }}" class="btn-primary mt-10" data-reveal="up" style="--delay:240ms">Selengkapnya tentang kami <x-icon name="arrow-right" class="size-4" /></a>
            </div>

            {{-- Sambutan kepala --}}
            <div class="relative" data-reveal="right">
                <div class="absolute -inset-4 -z-10 rotate-3 rounded-[2.5rem] bg-gradient-to-br from-brand-200 to-gold-300/60"></div>
                <div class="overflow-hidden rounded-[2rem] bg-ink text-white shadow-2xl">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-brand-700 to-ink">
                        @if (setting('kepala_foto'))
                            <img src="{{ media(setting('kepala_foto')) }}" alt="{{ setting('kepala_nama') }}" class="size-full object-cover object-top">
                        @else
                            <div class="bg-grid absolute inset-0"></div>
                            <x-icon name="user" class="absolute left-1/2 top-1/2 size-28 -translate-x-1/2 -translate-y-1/2 text-white/20" />
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/20 to-transparent"></div>
                        <div class="absolute bottom-0 p-7">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-300">Sambutan Kepala Badan</p>
                            <p class="mt-1 text-2xl font-extrabold">{{ setting('kepala_nama') }}</p>
                        </div>
                    </div>
                    <div class="relative p-7">
                        <x-icon name="quote" class="absolute right-6 top-6 size-10 text-white/10" />
                        <p class="leading-7 text-white/75">{{ setting('sambutan') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LAYANAN --}}
    <section class="relative overflow-hidden bg-slate-50 py-24 sm:py-32">
        <div class="container-x">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading eyebrow="Layanan Publik" title="Layanan online untuk wajib pajak" subtitle="Urus pajak daerah, BPHTB, dan PBB-P2 dari mana saja tanpa harus antre." />
                <a href="{{ route('layanan') }}" class="btn-outline" data-reveal="up">Persyaratan layanan <x-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $i => $service)
                    <a href="{{ $service->url }}" target="_blank" rel="noopener" data-reveal="up" style="--delay: {{ $i * 90 }}ms"
                       class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 transition duration-500 hover:-translate-y-2 hover:border-transparent hover:shadow-2xl hover:shadow-brand-900/15">
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-700 to-ink opacity-0 transition duration-500 group-hover:opacity-100"></div>
                        <div class="bg-grid absolute inset-0 opacity-0 transition duration-500 group-hover:opacity-100"></div>
                        <div class="relative">
                            <div class="flex items-start justify-between">
                                <span class="grid size-14 place-items-center rounded-2xl bg-brand-50 text-brand-600 transition duration-500 group-hover:rotate-6 group-hover:bg-gold-400 group-hover:text-ink">
                                    <x-icon :name="$service->icon" class="size-6" />
                                </span>
                                <span class="grid size-10 place-items-center rounded-full border border-slate-200 text-slate-400 transition duration-500 group-hover:rotate-45 group-hover:border-white/20 group-hover:text-white">
                                    <x-icon name="arrow-up-right" class="size-4" />
                                </span>
                            </div>
                            <h3 class="mt-8 text-xl font-extrabold text-slate-900 transition group-hover:text-white">{{ $service->title }}</h3>
                            <p class="mt-3 leading-7 text-slate-500 transition group-hover:text-white/70">{{ $service->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <section class="relative overflow-hidden bg-ink py-24 text-white sm:py-32">
        <div class="bg-grid absolute inset-0"></div>
        <div class="absolute left-1/2 top-0 size-[40rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="container-x relative text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-gold-400" data-reveal="up">Visi Kami</p>
            <blockquote class="mx-auto mt-6 max-w-4xl text-3xl font-extrabold leading-tight sm:text-5xl" data-reveal="up" style="--delay:100ms">
                &ldquo;{{ setting('visi') }}&rdquo;
            </blockquote>
            <div class="mx-auto mt-16 grid max-w-5xl gap-5 text-left md:grid-cols-3">
                @foreach (array_values(array_filter(explode("\n", (string) setting('misi')))) as $i => $misi)
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-7 backdrop-blur transition duration-500 hover:-translate-y-1 hover:border-brand-400/40 hover:bg-white/10" data-reveal="up" style="--delay: {{ 150 + $i * 100 }}ms">
                        <span class="text-5xl font-extrabold text-transparent [-webkit-text-stroke:1.5px_var(--color-gold-400)]">0{{ $i + 1 }}</span>
                        <p class="mt-4 leading-7 text-white/80">{{ $misi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BERITA & PENGUMUMAN --}}
    <section class="py-24 sm:py-32">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="flex flex-wrap items-end justify-between gap-6">
                    <x-section-heading eyebrow="Kabar Terbaru" title="Berita & kegiatan" />
                    <a href="{{ route('berita.index') }}" class="btn-outline" data-reveal="up">Semua berita <x-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @forelse ($posts as $i => $post)
                        <x-post-card :post="$post" :delay="$i * 100" />
                    @empty
                        <p class="text-slate-500">Belum ada berita.</p>
                    @endforelse
                </div>
            </div>
            <aside class="lg:col-span-4">
                <div class="sticky top-28 rounded-3xl bg-gradient-to-br from-brand-700 to-ink p-8 text-white shadow-2xl shadow-brand-900/20" data-reveal="right">
                    <div class="flex items-center gap-3">
                        <span class="grid size-11 place-items-center rounded-xl bg-gold-400 text-ink"><x-icon name="megaphone" /></span>
                        <h3 class="text-xl font-extrabold">Pengumuman</h3>
                    </div>
                    <ul class="mt-6 divide-y divide-white/10">
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
                    <a href="{{ route('pengumuman.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-gold-300">Lihat semua <x-icon name="arrow-right" class="size-4" /></a>
                </div>
            </aside>
        </div>
    </section>

    {{-- GALERI --}}
    @if ($photos->isNotEmpty())
        <section class="bg-slate-50 py-24 sm:py-32">
            <div class="container-x">
                <div class="flex flex-wrap items-end justify-between gap-6">
                    <x-section-heading eyebrow="Galeri" title="Dokumentasi kegiatan" />
                    <a href="{{ route('galeri') }}" class="btn-outline" data-reveal="up">Lihat galeri <x-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="mt-12 grid auto-rows-[180px] grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($photos as $i => $photo)
                        <a href="{{ route('galeri') }}" data-reveal="zoom" style="--delay: {{ $i * 80 }}ms"
                           class="group relative overflow-hidden rounded-3xl {{ $i === 0 ? 'col-span-2 row-span-2' : '' }}">
                            <img src="{{ media($photo->image) }}" alt="{{ $photo->title }}" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 flex items-end bg-gradient-to-t from-ink/80 to-transparent p-5 opacity-0 transition duration-500 group-hover:opacity-100">
                                <p class="font-semibold text-white">{{ $photo->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- LINK TERKAIT (marquee) --}}
    @if ($relatedLinks->isNotEmpty())
        <section class="border-y border-slate-200 py-10">
            <p class="text-center text-xs font-bold uppercase tracking-[0.25em] text-slate-400">Tautan Terkait</p>
            <div class="group relative mt-6 flex overflow-hidden [mask-image:linear-gradient(90deg,transparent,black_10%,black_90%,transparent)]">
                <div class="flex shrink-0 animate-marquee gap-4 pr-4 group-hover:[animation-play-state:paused]">
                    @foreach ($relatedLinks->concat($relatedLinks) as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="flex shrink-0 items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-brand-300 hover:text-brand-700">
                            <x-icon name="globe" class="size-4 text-brand-500" /> {{ $link->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-24">
        <div class="container-x">
            <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-brand-600 via-brand-700 to-ink px-8 py-16 text-white sm:px-16" data-reveal="zoom">
                <div class="bg-grid absolute inset-0"></div>
                <div class="absolute -right-20 -top-20 size-80 animate-blob rounded-full bg-gold-400/30 blur-3xl"></div>
                <div class="relative flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl font-extrabold leading-tight sm:text-4xl">Ada pertanyaan seputar pajak & retribusi daerah?</h2>
                        <p class="mt-4 text-lg text-white/75">Tim kami siap membantu. Kirim pesan atau kunjungi kantor kami di Barabai.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('kontak') }}" class="btn-gold !px-7 !py-3.5">Kirim Pesan <x-icon name="send" class="size-4" /></a>
                        <a href="{{ route('layanan') }}" class="btn-ghost !px-7 !py-3.5">Lihat Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
