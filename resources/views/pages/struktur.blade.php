<x-layouts.public title="Struktur Organisasi">
    <x-page-hero eyebrow="Profil" title="Struktur Organisasi" :crumbs="['Profil' => route('profil'), 'Struktur Organisasi' => null]" />

    <section class="py-16 sm:py-20">
        <div class="container-x">
            @if (setting('struktur_image'))
                <div x-data="{ zoom: false }" class="card overflow-hidden p-4 sm:p-8" data-reveal="zoom">
                    <img src="{{ media(setting('struktur_image')) }}" alt="Bagan struktur organisasi" @click="zoom = true" class="mx-auto w-full cursor-zoom-in rounded-lg bg-white">
                    <p class="mt-4 text-center text-sm text-slate-500 dark:text-navy-400">Klik bagan untuk memperbesar.</p>
                    <template x-teleport="body">
                        <div x-show="zoom" x-cloak x-transition.opacity @click="zoom = false" @keydown.escape.window="zoom = false" class="fixed inset-0 z-[90] grid cursor-zoom-out place-items-center overflow-auto bg-navy-950/95 p-6">
                            <img src="{{ media(setting('struktur_image')) }}" alt="" class="max-w-none rounded-lg bg-white lg:max-w-[140vw]">
                        </div>
                    </template>
                </div>
            @else
                {{-- Bagan otomatis dari data pegawai bila gambar bagan belum diunggah --}}
                <div class="flex flex-col items-center">
                    @foreach ($leaders as $i => $leader)
                        @if ($i === 0)
                            <div class="w-full max-w-sm rounded-xl border-t-4 border-gold-500 bg-navy-900 p-6 text-center text-white shadow-lg" data-reveal="zoom">
                                <p class="text-xs font-bold uppercase tracking-[0.15em] text-gold-300">{{ $leader->position }}</p>
                                <p class="mt-2 text-xl font-extrabold">{{ $leader->name }}</p>
                            </div>
                            <div class="h-12 w-px bg-slate-300 dark:bg-navy-700"></div>
                            @if ($leaders->count() > 1)
                                <div class="h-px w-full max-w-4xl bg-slate-300 dark:bg-navy-700"></div>
                                <div class="grid w-full max-w-5xl gap-6 md:grid-cols-3">
                            @endif
                        @else
                                <div class="flex flex-col items-center" data-reveal="up" style="--delay: {{ $i * 80 }}ms">
                                    <div class="h-8 w-px bg-slate-300 dark:bg-navy-700"></div>
                                    <div class="card w-full border-t-4 !border-t-brand-600 p-6 text-center">
                                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-700 dark:text-brand-300">{{ $leader->position }}</p>
                                        <p class="mt-2 font-extrabold text-navy-900 dark:text-white">{{ $leader->name }}</p>
                                    </div>
                                </div>
                        @endif
                    @endforeach
                    @if ($leaders->count() > 1)</div>@endif
                    <p class="mt-12 text-sm text-slate-500 dark:text-navy-400">Bagan lengkap dapat diunggah melalui menu Profil di CMS.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
