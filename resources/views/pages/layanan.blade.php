<x-layouts.public title="Layanan">
    <x-page-hero eyebrow="Layanan Publik" title="Layanan & Persyaratan" subtitle="Semua layanan online dan persyaratannya dalam satu halaman." :crumbs="['Layanan' => null]" />

    <section class="py-16 sm:py-20">
        <div class="container-x">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $i => $service)
                    <x-service-card :service="$service" :delay="$i * 80" />
                @endforeach
            </div>

            <div class="mt-20">
                <x-section-heading eyebrow="Standar Pelayanan" title="Jenis layanan & persyaratan" />
                <div class="mt-8 space-y-3">
                    @foreach ($types as $i => $type)
                        <div x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }" class="card overflow-hidden" data-reveal="up" style="--delay: {{ $i * 60 }}ms">
                            <button type="button" @click="open = !open" :aria-expanded="open" class="flex w-full items-center gap-5 p-5 text-left">
                                <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-navy-900 font-extrabold text-gold-300 dark:bg-navy-800">{{ $i + 1 }}</span>
                                <span class="flex-1">
                                    <span class="block text-lg font-extrabold text-navy-900 dark:text-white">{{ $type->name }}</span>
                                    <span class="block text-sm text-slate-500 dark:text-navy-300">{{ $type->notes }}</span>
                                </span>
                                <span class="hidden gap-2 md:flex">
                                    @if ($type->duration)<span class="rounded bg-brand-50 px-2.5 py-1 text-xs font-bold text-brand-800 dark:bg-brand-950 dark:text-brand-300">{{ $type->duration }}</span>@endif
                                    @if ($type->cost)<span class="rounded bg-gold-200/60 px-2.5 py-1 text-xs font-bold text-gold-600 dark:bg-gold-500/15 dark:text-gold-300">{{ $type->cost }}</span>@endif
                                </span>
                                <x-icon name="chevron-down" class="size-5 text-slate-400 transition duration-300" ::class="open && 'rotate-180'" />
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="grid gap-6 border-t border-slate-100 p-6 md:grid-cols-3 dark:border-navy-800">
                                    <div class="md:col-span-2">
                                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400 dark:text-navy-400">Persyaratan</p>
                                        @php $reqs = array_filter(explode("\n", (string) $type->requirements)); @endphp
                                        @if ($reqs)
                                            <ul class="mt-3 space-y-2">
                                                @foreach ($reqs as $req)
                                                    <li class="flex gap-2 text-slate-700 dark:text-navy-200"><x-icon name="check" class="mt-0.5 size-4 text-brand-600 dark:text-brand-400" /> {{ $req }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-3 text-slate-500 dark:text-navy-300">Tidak ada persyaratan khusus.</p>
                                        @endif
                                    </div>
                                    <div class="space-y-3 text-sm">
                                        <p><span class="text-slate-500 dark:text-navy-400">Jangka waktu:</span> <b class="text-navy-900 dark:text-white">{{ $type->duration ?: '-' }}</b></p>
                                        <p><span class="text-slate-500 dark:text-navy-400">Biaya:</span> <b class="text-navy-900 dark:text-white">{{ $type->cost ?: '-' }}</b></p>
                                        @if ($type->url)<a href="{{ $type->url }}" target="_blank" rel="noopener" class="btn-primary mt-2">Buka layanan <x-icon name="arrow-up-right" class="size-4" /></a>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
