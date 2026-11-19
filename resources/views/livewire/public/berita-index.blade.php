<div>
    <x-page-hero eyebrow="Informasi" title="Berita & Kegiatan" subtitle="Kabar terbaru seputar keuangan, pajak, dan pendapatan daerah Kabupaten Hulu Sungai Tengah." :crumbs="['Berita' => null]">
        <div class="relative mt-8 max-w-xl">
            <x-icon name="search" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-navy-300" />
            <label for="cari-berita" class="sr-only">Cari berita</label>
            <input id="cari-berita" wire:model.live.debounce.400ms="search" type="search" placeholder="Cari berita..."
                   class="w-full rounded-lg border border-white/20 bg-white/10 py-3.5 pl-12 pr-4 text-white placeholder:text-navy-300 focus:border-gold-400 focus:outline-none focus:ring-4 focus:ring-gold-400/20">
        </div>
    </x-page-hero>

    <section class="py-14 sm:py-16">
        <div class="container-x">
            @if ($search !== '')
                <p class="mb-6 text-sm text-slate-600 dark:text-navy-300">{{ $posts->total() }} hasil untuk <b class="text-navy-900 dark:text-white">&ldquo;{{ $search }}&rdquo;</b></p>
            @endif

            @if ($featured)
                <div class="relative isolate mb-14" wire:key="featured-{{ $featured->id }}" data-reveal="up">
                    <div class="absolute -inset-3 -z-10 rotate-1 rounded-[2.75rem] bg-gradient-to-br from-brand-200 to-gold-300/60 dark:from-brand-900 dark:to-gold-500/25"></div>
                    <a href="{{ route('berita.show', $featured) }}" class="group grid overflow-hidden rounded-[2.25rem] bg-ink text-white shadow-2xl lg:grid-cols-2 dark:bg-navy-900 dark:ring-1 dark:ring-white/10">
                        <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-brand-700 to-ink lg:aspect-auto lg:min-h-96">
                            <x-post-thumb :post="$featured" class="transition duration-700 group-hover:scale-105" />
                            <div class="absolute inset-0 bg-gradient-to-t from-ink/60 to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-ink/40"></div>
                        </div>
                        <div class="flex flex-col justify-center p-8 sm:p-12">
                            <span class="w-fit rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-ink">Berita Utama</span>
                            <h2 class="mt-5 text-2xl font-extrabold leading-tight transition group-hover:text-gold-300 sm:text-3xl">{{ $featured->title }}</h2>
                            <p class="mt-4 leading-7 text-white/70">{{ $featured->summary(240) }}</p>
                            <p class="mt-6 text-xs font-bold uppercase tracking-[0.2em] text-gold-300">{{ $featured->published_at?->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </a>
                </div>
            @endif

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" wire:loading.class="opacity-50">
                @forelse ($posts as $i => $post)
                    @continue($featured && $post->is($featured))
                    <div wire:key="post-{{ $post->id }}"><x-post-card :post="$post" :delay="($i % 3) * 80" /></div>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-slate-300 p-16 text-center text-slate-500 dark:border-navy-700 dark:text-navy-300">
                        <x-icon name="search" class="mx-auto size-10 text-slate-300 dark:text-navy-600" />
                        <p class="mt-4">Tidak ada berita{{ $search ? ' untuk "'.$search.'"' : '' }}.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-12">{{ $posts->links() }}</div>
        </div>
    </section>
</div>
