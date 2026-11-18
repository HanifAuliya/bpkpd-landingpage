<x-layouts.public title="Pengumuman">
    <x-page-hero eyebrow="Informasi" title="Pengumuman" subtitle="Informasi resmi dan pemberitahuan terbaru untuk masyarakat." :crumbs="['Pengumuman' => null]" />

    <section class="py-24">
        <div class="container-x max-w-4xl">
            <div class="space-y-4">
                @forelse ($items as $i => $item)
                    <a href="{{ route('pengumuman.show', $item) }}" class="card card-hover group flex items-center gap-6 p-6" data-reveal="up" style="--delay: {{ $i * 60 }}ms">
                        <span class="flex size-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-brand-600 text-white">
                            <span class="text-xl font-extrabold leading-none">{{ $item->published_at?->format('d') }}</span>
                            <span class="text-[11px] font-bold uppercase">{{ $item->published_at?->translatedFormat('M') }}</span>
                        </span>
                        <span class="flex-1">
                            <span class="block text-lg font-bold text-slate-900 group-hover:text-brand-700">{{ $item->title }}</span>
                            <span class="mt-1 flex items-center gap-3 text-sm text-slate-500">
                                {{ $item->published_at?->translatedFormat('d F Y') }}
                                @if ($item->attachment)<span class="inline-flex items-center gap-1 text-brand-700"><x-icon name="file" class="size-4" /> Lampiran</span>@endif
                            </span>
                        </span>
                        <x-icon name="arrow-right" class="size-5 text-slate-300 transition group-hover:translate-x-1 group-hover:text-brand-600" />
                    </a>
                @empty
                    <p class="text-center text-slate-500">Belum ada pengumuman.</p>
                @endforelse
            </div>
            <div class="mt-10">{{ $items->links() }}</div>
        </div>
    </section>
</x-layouts.public>
