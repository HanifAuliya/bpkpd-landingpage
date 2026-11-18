<x-layouts.public :title="$post->title" :description="$post->summary()">
    <x-page-hero eyebrow="Berita" :title="$post->title" :crumbs="['Berita' => route('berita.index'), \Illuminate\Support\Str::limit($post->title, 40) => null]">
        <div class="mt-8 flex flex-wrap gap-5 text-sm text-white/60" data-reveal="up" style="--delay:240ms">
            <span class="flex items-center gap-2"><x-icon name="calendar" class="size-4 text-gold-400" /> {{ $post->published_at?->translatedFormat('l, d F Y') }}</span>
            <span class="flex items-center gap-2"><x-icon name="clock" class="size-4 text-gold-400" /> {{ $post->readingTime() }} menit baca</span>
            <span class="flex items-center gap-2"><x-icon name="eye" class="size-4 text-gold-400" /> {{ number_format($post->views) }} kali dibaca</span>
        </div>
    </x-page-hero>

    <article class="py-16">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                @if ($post->image)
                    <img src="{{ media($post->image) }}" alt="" class="-mt-32 mb-12 w-full rounded-[2rem] shadow-2xl ring-8 ring-white" data-reveal="zoom">
                @endif
                <div class="prose-content" data-reveal="up">{!! $post->body !!}</div>

                <div x-data="{ copied: false }" class="mt-12 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-8">
                    <span class="text-sm font-bold text-slate-900">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($post->title.' '.url()->current()) }}" target="_blank" rel="noopener" class="btn-outline !py-2">WhatsApp</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn-outline !py-2">Facebook</a>
                    <button type="button" @click="navigator.clipboard.writeText(location.href); copied = true; setTimeout(() => copied = false, 2000)" class="btn-outline !py-2">
                        <x-icon name="link" class="size-4" /> <span x-text="copied ? 'Tersalin!' : 'Salin tautan'">Salin tautan</span>
                    </button>
                </div>
            </div>
            <aside class="lg:col-span-4">
                <div class="sticky top-28">
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-400">Berita lainnya</p>
                    <div class="mt-5 space-y-4">
                        @foreach ($related as $item)
                            <a href="{{ route('berita.show', $item) }}" class="group flex gap-4 rounded-2xl p-2 transition hover:bg-slate-50">
                                <span class="relative size-20 shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-brand-600 to-ink">
                                    @if ($item->image)<img src="{{ media($item->image) }}" alt="" class="size-full object-cover transition duration-500 group-hover:scale-110">@endif
                                </span>
                                <span>
                                    <span class="text-xs font-semibold text-brand-600">{{ $item->published_at?->translatedFormat('d M Y') }}</span>
                                    <span class="mt-1 line-clamp-2 block font-bold leading-snug text-slate-900 group-hover:text-brand-700">{{ $item->title }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </article>
</x-layouts.public>
