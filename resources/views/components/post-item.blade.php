@props(['post', 'delay' => 0])
{{-- Berita versi ringkas (daftar samping), senada dengan kartu berita --}}
<a href="{{ route('berita.show', $post) }}" class="group flex gap-4 rounded-2xl bg-ink p-3 text-white shadow-lg shadow-navy-900/10 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl dark:bg-navy-900 dark:ring-1 dark:ring-white/10" data-reveal="up" style="--delay: {{ $delay }}ms">
    <span class="relative block aspect-[4/3] w-28 shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-brand-700 to-ink">
        <x-post-thumb :post="$post" class="transition duration-500 group-hover:scale-110" />
    </span>
    <span class="min-w-0 py-1 pr-1">
        <span class="block text-[11px] font-bold uppercase tracking-[0.15em] text-gold-300">{{ $post->published_at?->translatedFormat('d M Y') }}</span>
        <span class="mt-1.5 line-clamp-3 block text-sm font-bold leading-snug transition group-hover:text-gold-300">{{ $post->title }}</span>
    </span>
</a>
