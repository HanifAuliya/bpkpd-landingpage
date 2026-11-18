<x-layouts.public title="Galeri Foto">
    <x-page-hero eyebrow="Informasi" title="Galeri Foto" subtitle="Dokumentasi kegiatan {{ setting('nama_singkat') }}." :crumbs="['Galeri' => null]" />

    @php $items = $photos->map(fn ($p) => ['src' => media($p->image), 'title' => $p->title, 'desc' => $p->description])->values(); @endphp
    <section class="py-24" x-data="{ items: @js($items), open: false, i: 0, show(n) { this.i = n; this.open = true }, next() { this.i = (this.i + 1) % this.items.length }, prev() { this.i = (this.i - 1 + this.items.length) % this.items.length } }"
             @keydown.escape.window="open = false" @keydown.arrow-right.window="open && next()" @keydown.arrow-left.window="open && prev()">
        <div class="container-x">
            @if ($photos->isEmpty())
                <p class="text-center text-slate-500">Belum ada foto.</p>
            @endif
            <div class="columns-1 gap-5 sm:columns-2 lg:columns-3">
                @foreach ($photos as $n => $photo)
                    <button type="button" @click="show({{ $n }})" class="group relative mb-5 block w-full overflow-hidden rounded-3xl" data-reveal="up" style="--delay: {{ ($n % 6) * 70 }}ms">
                        <img src="{{ media($photo->image) }}" alt="{{ $photo->title }}" loading="lazy" class="w-full transition duration-700 group-hover:scale-105">
                        <span class="absolute inset-0 flex items-end bg-gradient-to-t from-ink/85 via-ink/10 to-transparent p-5 text-left opacity-0 transition duration-500 group-hover:opacity-100">
                            <span><span class="block font-bold text-white">{{ $photo->title }}</span>@if($photo->taken_at)<span class="text-xs text-white/70">{{ $photo->taken_at->translatedFormat('d F Y') }}</span>@endif</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[90] flex items-center justify-center bg-ink/95 p-4 backdrop-blur" @click.self="open = false">
                <button @click="open = false" class="absolute right-5 top-5 grid size-12 place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="Tutup"><x-icon name="x" /></button>
                <button @click="prev()" class="absolute left-4 grid size-12 place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="Sebelumnya"><x-icon name="chevron-left" /></button>
                <figure class="max-w-5xl text-center">
                    <img :src="items[i]?.src" alt="" class="max-h-[78vh] rounded-2xl">
                    <figcaption class="mt-4 text-white"><p class="font-bold" x-text="items[i]?.title"></p><p class="text-sm text-white/60" x-text="items[i]?.desc"></p></figcaption>
                </figure>
                <button @click="next()" class="absolute right-4 grid size-12 place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="Berikutnya"><x-icon name="chevron-right" /></button>
            </div>
        </template>
    </section>
</x-layouts.public>
