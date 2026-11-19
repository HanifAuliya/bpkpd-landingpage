<x-layouts.public title="Pengumuman">
    <x-page-hero eyebrow="Informasi Publik" title="Pengumuman" subtitle="Informasi resmi dan pemberitahuan terbaru untuk masyarakat." :crumbs="['Pengumuman' => null]" />

    <section class="py-16 sm:py-20">
        <div class="container-x max-w-4xl">
            <div class="card divide-y divide-slate-100 dark:divide-navy-800">
                @forelse ($items as $i => $item)
                    <a href="{{ route('pengumuman.show', $item) }}" class="group flex items-center gap-5 p-5 transition hover:bg-slate-50 dark:hover:bg-navy-800" data-reveal="up" style="--delay: {{ $i * 50 }}ms">
                        <span class="flex size-16 shrink-0 flex-col items-center justify-center rounded-lg border-t-4 border-gold-500 bg-navy-900 text-white dark:bg-navy-800">
                            <span class="text-xl font-extrabold leading-none">{{ $item->published_at?->format('d') }}</span>
                            <span class="mt-0.5 text-[11px] font-bold uppercase text-navy-200">{{ $item->published_at?->translatedFormat('M Y') }}</span>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-lg font-bold leading-snug text-navy-900 group-hover:text-brand-700 dark:text-white dark:group-hover:text-brand-300">{{ $item->title }}</span>
                            <span class="mt-1 flex items-center gap-3 text-sm text-slate-500 dark:text-navy-300">
                                {{ $item->published_at?->translatedFormat('l, d F Y') }}
                                @if ($item->attachment)<span class="inline-flex items-center gap-1 font-semibold text-brand-700 dark:text-brand-300"><x-icon name="file" class="size-4" /> Lampiran</span>@endif
                            </span>
                        </span>
                        <x-icon name="arrow-right" class="size-5 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-brand-600 dark:text-navy-600" />
                    </a>
                @empty
                    <p class="p-10 text-center text-slate-500 dark:text-navy-300">Belum ada pengumuman.</p>
                @endforelse
            </div>
            <div class="mt-10">{{ $items->links() }}</div>
        </div>
    </section>
</x-layouts.public>
