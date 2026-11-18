<x-layouts.public :title="$item->title">
    <x-page-hero eyebrow="Pengumuman" :title="$item->title" :crumbs="['Pengumuman' => route('pengumuman.index'), 'Detail' => null]">
        <p class="mt-6 flex items-center gap-2 text-sm text-white/60"><x-icon name="calendar" class="size-4 text-gold-400" /> {{ $item->published_at?->translatedFormat('l, d F Y') }}</p>
    </x-page-hero>
    <section class="py-16">
        <div class="container-x grid gap-14 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="prose-content" data-reveal="up">{!! $item->body !!}</div>
                @if ($item->attachment)
                    <a href="{{ media($item->attachment) }}" target="_blank" class="card card-hover mt-10 flex items-center gap-4 p-5">
                        <span class="grid size-12 place-items-center rounded-xl bg-brand-50 text-brand-600"><x-icon name="file" /></span>
                        <span class="flex-1 font-bold text-slate-900">Unduh lampiran</span>
                        <x-icon name="download" class="text-brand-600" />
                    </a>
                @endif
            </div>
            <aside class="lg:col-span-4">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-slate-400">Pengumuman lainnya</p>
                <ul class="mt-5 divide-y divide-slate-100">
                    @foreach ($others as $other)
                        <li><a href="{{ route('pengumuman.show', $other) }}" class="block py-4 font-semibold text-slate-800 hover:text-brand-700">{{ $other->title }}</a></li>
                    @endforeach
                </ul>
            </aside>
        </div>
    </section>
</x-layouts.public>
