<x-layouts.public :title="$post->title" :description="$post->summary()">
    <x-page-hero eyebrow="Berita" :title="$post->title" :crumbs="['Berita' => route('berita.index'), \Illuminate\Support\Str::limit($post->title, 40) => null]">
        <div class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm text-navy-200">
            <span class="flex items-center gap-2"><x-icon name="calendar" class="size-4 text-gold-400" /> {{ $post->published_at?->translatedFormat('l, d F Y') }}</span>
            <span class="flex items-center gap-2"><x-icon name="clock" class="size-4 text-gold-400" /> {{ $post->readingTime() }} menit baca</span>
            <span class="flex items-center gap-2"><x-icon name="eye" class="size-4 text-gold-400" /> {{ number_format($post->views) }} kali dibaca</span>
        </div>
    </x-page-hero>

    <article class="py-12 sm:py-16">
        <div class="container-x grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-8">
                @if ($post->image)
                    <img src="{{ media($post->image) }}" alt="{{ $post->title }}" class="mb-10 w-full rounded-[2rem] shadow-2xl shadow-navy-900/15 dark:ring-1 dark:ring-white/10">
                @endif
                <div class="prose-content">{!! $post->body !!}</div>

                <div x-data="{ copied: false }" class="mt-10 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-8 dark:border-navy-800">
                    <span class="text-sm font-bold text-navy-900 dark:text-white">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($post->title.' '.url()->current()) }}" target="_blank" rel="noopener" class="btn-outline !py-2">WhatsApp</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn-outline !py-2"><x-icon name="facebook" class="size-4" /> Facebook</a>
                    <button type="button" @click="navigator.clipboard.writeText(location.href); copied = true; setTimeout(() => copied = false, 2000)" class="btn-outline !py-2">
                        <x-icon name="link" class="size-4" /> <span x-text="copied ? 'Tersalin!' : 'Salin tautan'">Salin tautan</span>
                    </button>
                </div>
            </div>
            <aside class="lg:col-span-4">
                <div class="sticky top-28">
                    <p class="eyebrow">Berita lainnya</p>
                    <div class="mt-5 space-y-4">
                        @foreach ($related as $i => $item)
                            <x-post-item :post="$item" :delay="$i * 60" />
                        @endforeach
                    </div>
                    <a href="{{ route('berita.index') }}" class="btn-outline mt-6 w-full">Semua berita <x-icon name="arrow-right" class="size-4" /></a>
                </div>
            </aside>
        </div>
    </article>
</x-layouts.public>
