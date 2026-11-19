<x-layouts.public title="Galeri Foto">
    <x-page-hero eyebrow="Informasi Publik" title="Galeri Foto" subtitle="Dokumentasi kegiatan {{ setting('nama_singkat') }}." :crumbs="['Galeri' => null]" />

    @php $items = $photos->map(fn ($p) => ['src' => media($p->image), 'title' => $p->title, 'desc' => $p->description])->values(); @endphp
    <section class="py-16 sm:py-20" x-data="{ items: @js($items), open: false, i: 0, show(n) { this.i = n; this.open = true }, next() { this.i = (this.i + 1) % this.items.length }, prev() { this.i = (this.i - 1 + this.items.length) % this.items.length } }"
             @keydown.escape.window="open = false" @keydown.arrow-right.window="open && next()" @keydown.arrow-left.window="open && prev()">
        <div class="container-x">
            @if ($photos->isEmpty())
                <p class="text-center text-slate-500 dark:text-navy-300">Belum ada foto.</p>
            @endif
            <div class="columns-1 gap-4 sm:columns-2 lg:columns-3">
                @foreach ($photos as $n => $photo)
                    <button type="button" @click="show({{ $n }})" class="group relative mb-4 block w-full overflow-hidden rounded-xl" data-reveal="up" style="--delay: {{ ($n % 6) * 60 }}ms">
                        <img src="{{ media($photo->image) }}" alt="{{ $photo->title }}" loading="lazy" class="w-full transition duration-500 group-hover:scale-[1.03]">
                        <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950/85 to-transparent p-4 pt-12 text-left opacity-0 transition group-hover:opacity-100">
                            <span class="block font-bold text-white">{{ $photo->title }}</span>@if($photo->taken_at)<span class="text-xs text-navy-200">{{ $photo->taken_at->translatedFormat('d F Y') }}</span>@endif
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[90] flex items-center justify-center bg-navy-950/95 p-4" @click.self="open = false" role="dialog" aria-modal="true">
                <button @click="open = false" class="absolute right-5 top-5 grid size-11 place-items-center rounded-lg bg-white/10 text-white hover:bg-white/20" aria-label="Tutup"><x-icon name="x" /></button>
                <button @click="prev()" class="absolute left-4 grid size-11 place-items-center rounded-lg bg-white/10 text-white hover:bg-white/20" aria-label="Sebelumnya"><x-icon name="chevron-left" /></button>
                <figure class="max-w-5xl text-center">
                    <img :src="items[i]?.src" alt="" class="max-h-[78vh] rounded-lg">
                    <figcaption class="mt-4 text-white"><p class="font-bold" x-text="items[i]?.title"></p><p class="text-sm text-navy-300" x-text="items[i]?.desc"></p></figcaption>
                </figure>
                <button @click="next()" class="absolute right-4 grid size-11 place-items-center rounded-lg bg-white/10 text-white hover:bg-white/20" aria-label="Berikutnya"><x-icon name="chevron-right" /></button>
            </div>
        </template>
    </section>
</x-layouts.public>
