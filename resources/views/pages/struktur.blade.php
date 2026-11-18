<x-layouts.public title="Struktur Organisasi">
    <x-page-hero eyebrow="Profil" title="Struktur Organisasi" :crumbs="['Profil' => route('profil'), 'Struktur Organisasi' => null]" />

    <section class="py-24">
        <div class="container-x">
            @if (setting('struktur_image'))
                <div x-data="{ zoom: false }" class="card overflow-hidden p-4 sm:p-8" data-reveal="zoom">
                    <img src="{{ media(setting('struktur_image')) }}" alt="Bagan struktur organisasi" @click="zoom = true" class="mx-auto w-full cursor-zoom-in rounded-2xl">
                    <template x-teleport="body">
                        <div x-show="zoom" x-cloak x-transition.opacity @click="zoom = false" @keydown.escape.window="zoom = false" class="fixed inset-0 z-[90] grid cursor-zoom-out place-items-center overflow-auto bg-ink/95 p-6">
                            <img src="{{ media(setting('struktur_image')) }}" alt="" class="max-w-none rounded-xl lg:max-w-[140vw]">
                        </div>
                    </template>
                </div>
            @else
                {{-- Bagan otomatis dari data pegawai bila gambar bagan belum diunggah --}}
                <div class="flex flex-col items-center">
                    @foreach ($leaders as $i => $leader)
                        @if ($i === 0)
                            <div class="w-full max-w-sm rounded-3xl bg-gradient-to-br from-brand-600 to-ink p-6 text-center text-white shadow-2xl" data-reveal="zoom">
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold-300">{{ $leader->position }}</p>
                                <p class="mt-2 text-xl font-extrabold">{{ $leader->name }}</p>
                            </div>
                            <div class="h-12 w-px bg-brand-300"></div>
                            @if ($leaders->count() > 1)
                                <div class="h-px w-full max-w-4xl bg-brand-300"></div>
                                <div class="grid w-full max-w-5xl gap-6 md:grid-cols-3">
                            @endif
                        @else
                                <div class="flex flex-col items-center" data-reveal="up" style="--delay: {{ $i * 100 }}ms">
                                    <div class="h-8 w-px bg-brand-300"></div>
                                    <div class="card w-full p-6 text-center">
                                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-brand-600">{{ $leader->position }}</p>
                                        <p class="mt-2 font-extrabold text-slate-900">{{ $leader->name }}</p>
                                    </div>
                                </div>
                        @endif
                    @endforeach
                    @if ($leaders->count() > 1)</div>@endif
                    <p class="mt-12 text-sm text-slate-500">Bagan lengkap dapat diunggah melalui menu Profil di CMS.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
