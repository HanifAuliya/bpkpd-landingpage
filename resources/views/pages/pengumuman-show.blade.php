<x-layouts.public :title="$item->title">
    <x-page-hero eyebrow="Pengumuman" :title="$item->title" :crumbs="['Pengumuman' => route('pengumuman.index'), 'Detail' => null]">
        <p class="mt-6 flex items-center gap-2 text-sm text-navy-200"><x-icon name="calendar" class="size-4 text-gold-400" /> {{ $item->published_at?->translatedFormat('l, d F Y') }}</p>
    </x-page-hero>
    <section class="py-12 sm:py-16">
        <div class="container-x grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="prose-content">{!! $item->body !!}</div>
                @if ($item->attachment)
                    <a href="{{ media($item->attachment) }}" target="_blank" class="card card-hover mt-10 flex items-center gap-4 p-5">
                        <span class="grid size-12 place-items-center rounded-lg bg-brand-50 text-brand-700 dark:bg-brand-950 dark:text-brand-300"><x-icon name="file" /></span>
                        <span class="flex-1 font-bold text-navy-900 dark:text-white">Unduh lampiran</span>
                        <x-icon name="download" class="text-brand-700 dark:text-brand-300" />
                    </a>
                @endif
            </div>
            <aside class="lg:col-span-4">
                <div class="card overflow-hidden">
                    <p class="border-b border-slate-200 px-5 py-4 font-bold text-navy-900 dark:border-navy-800 dark:text-white">Pengumuman lainnya</p>
                    <ul class="divide-y divide-slate-100 dark:divide-navy-800">
                        @forelse ($others as $other)
                            <li><a href="{{ route('pengumuman.show', $other) }}" class="block px-5 py-4 text-sm font-semibold text-navy-900 hover:bg-slate-50 hover:text-brand-700 dark:text-white dark:hover:bg-navy-800 dark:hover:text-brand-300">{{ $other->title }}</a></li>
                        @empty
                            <li class="px-5 py-4 text-sm text-slate-500 dark:text-navy-300">Tidak ada pengumuman lain.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>
