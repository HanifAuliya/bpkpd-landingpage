@props(['post', 'delay' => 0])
{{-- Kartu berita bergaya sama dengan kartu Sambutan Kepala Badan --}}
<article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] bg-ink text-white shadow-xl shadow-navy-900/10 transition duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-navy-900/25 dark:bg-navy-900 dark:shadow-black/30 dark:ring-1 dark:ring-white/10" data-reveal="up" style="--delay: {{ $delay }}ms">
    <a href="{{ route('berita.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden bg-gradient-to-br from-brand-700 to-ink" tabindex="-1" aria-hidden="true">
        <x-post-thumb :post="$post" class="transition duration-700 group-hover:scale-105" />
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/10 to-transparent dark:from-navy-900"></div>
        <p class="absolute bottom-0 left-0 p-6 pb-3 text-xs font-bold uppercase tracking-[0.2em] text-gold-300">
            <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d F Y') }}</time>
        </p>
    </a>
    <div class="relative flex flex-1 flex-col px-6 pb-6 pt-2">
        <h3 class="text-lg font-extrabold leading-snug transition group-hover:text-gold-300">
            <a href="{{ route('berita.show', $post) }}">{{ $post->title }}</a>
        </h3>
        <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-white/70">{{ $post->summary() }}</p>
        <a href="{{ route('berita.show', $post) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-gold-300">
            Baca selengkapnya <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
        </a>
    </div>
</article>
