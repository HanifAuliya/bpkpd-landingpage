<div>
    <x-page-hero eyebrow="Informasi" title="Berita & Kegiatan" subtitle="Kabar terbaru seputar keuangan, pajak, dan pendapatan daerah." :crumbs="['Berita' => null]">
        <div class="relative mt-10 max-w-xl" data-reveal="up" style="--delay:260ms">
            <x-icon name="search" class="absolute left-5 top-1/2 size-5 -translate-y-1/2 text-white/50" />
            <input wire:model.live.debounce.400ms="search" type="search" placeholder="Cari berita..." class="w-full rounded-full border border-white/15 bg-white/10 py-4 pl-14 pr-5 text-white backdrop-blur placeholder:text-white/50 focus:border-gold-400 focus:outline-none focus:ring-4 focus:ring-gold-400/20">
        </div>
    </x-page-hero>

    <section class="py-20">
        <div class="container-x">
            @if ($featured)
                <a href="{{ route('berita.show', $featured) }}" wire:key="featured-{{ $featured->id }}" class="group mb-12 grid overflow-hidden rounded-[2rem] bg-ink text-white shadow-2xl lg:grid-cols-2" data-reveal="up">
                    <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-brand-600 to-ink lg:aspect-auto">
                        @if ($featured->image)<img src="{{ media($featured->image) }}" alt="" class="size-full object-cover transition duration-700 group-hover:scale-105">@else<div class="bg-grid absolute inset-0"></div>@endif
                    </div>
                    <div class="flex flex-col justify-center p-8 sm:p-12">
                        <span class="w-fit rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-ink">Terbaru</span>
                        <h2 class="mt-5 text-2xl font-extrabold leading-tight transition group-hover:text-gold-300 sm:text-3xl">{{ $featured->title }}</h2>
                        <p class="mt-4 leading-7 text-white/70">{{ $featured->summary(220) }}</p>
                        <p class="mt-6 text-sm text-white/50">{{ $featured->published_at?->translatedFormat('d F Y') }}</p>
                    </div>
                </a>
            @endif

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" wire:loading.class="opacity-50">
                @forelse ($posts as $i => $post)
                    @continue($featured && $post->is($featured))
                    <div wire:key="post-{{ $post->id }}"><x-post-card :post="$post" :delay="($i % 3) * 90" /></div>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-slate-300 p-16 text-center text-slate-500">
                        <x-icon name="search" class="mx-auto size-10 text-slate-300" />
                        <p class="mt-4">Tidak ada berita{{ $search ? ' untuk "'.$search.'"' : '' }}.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-12">{{ $posts->links() }}</div>
        </div>
    </section>
</div>
