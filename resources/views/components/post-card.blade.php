@props(['post', 'delay' => 0])
<article class="card card-hover group flex flex-col overflow-hidden" data-reveal="up" style="--delay: {{ $delay }}ms">
    <a href="{{ route('berita.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden bg-gradient-to-br from-brand-700 to-ink">
        @if ($post->image)
            <img src="{{ media($post->image) }}" alt="" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-110">
        @else
            <div class="bg-grid absolute inset-0"></div>
            <x-icon name="newspaper" class="absolute left-1/2 top-1/2 size-14 -translate-x-1/2 -translate-y-1/2 text-white/25 transition duration-700 group-hover:scale-125" />
        @endif
        <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-brand-800 backdrop-blur">
            {{ $post->published_at?->translatedFormat('d M Y') }}
        </span>
    </a>
    <div class="flex flex-1 flex-col p-6">
        <h3 class="text-lg font-bold leading-snug text-slate-900 transition group-hover:text-brand-700">
            <a href="{{ route('berita.show', $post) }}">{{ $post->title }}</a>
        </h3>
        <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-slate-500">{{ $post->summary() }}</p>
        <a href="{{ route('berita.show', $post) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
            Baca selengkapnya <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
        </a>
    </div>
</article>
