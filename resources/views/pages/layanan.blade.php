<x-layouts.public title="Layanan">
    <x-page-hero eyebrow="Layanan Publik" title="Layanan & Persyaratan" subtitle="Semua layanan online dan persyaratannya dalam satu halaman." :crumbs="['Layanan' => null]" />

    <section class="py-24">
        <div class="container-x">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $i => $service)
                    <a href="{{ $service->url }}" target="_blank" rel="noopener" class="card card-hover group flex items-start gap-5 p-7" data-reveal="up" style="--delay: {{ $i * 80 }}ms">
                        <span class="grid size-14 shrink-0 place-items-center rounded-2xl bg-brand-50 text-brand-600 transition duration-500 group-hover:rotate-6 group-hover:bg-brand-600 group-hover:text-white"><x-icon :name="$service->icon" class="size-6" /></span>
                        <span>
                            <span class="flex items-center gap-2 text-lg font-extrabold text-slate-900">{{ $service->title }} <x-icon name="arrow-up-right" class="size-4 text-slate-400 transition group-hover:text-brand-600" /></span>
                            <span class="mt-2 block text-sm leading-6 text-slate-500">{{ $service->description }}</span>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-24">
                <x-section-heading eyebrow="Standar Pelayanan" title="Jenis layanan & persyaratan" />
                <div class="mt-10 space-y-4">
                    @foreach ($types as $i => $type)
                        <div x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }" class="card overflow-hidden" data-reveal="up" style="--delay: {{ $i * 70 }}ms">
                            <button type="button" @click="open = !open" class="flex w-full items-center gap-5 p-6 text-left">
                                <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-brand-600 font-extrabold text-white">{{ $i + 1 }}</span>
                                <span class="flex-1">
                                    <span class="block text-lg font-extrabold text-slate-900">{{ $type->name }}</span>
                                    <span class="block text-sm text-slate-500">{{ $type->notes }}</span>
                                </span>
                                <span class="hidden gap-2 md:flex">
                                    @if ($type->duration)<span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700">{{ $type->duration }}</span>@endif
                                    @if ($type->cost)<span class="rounded-full bg-gold-300/30 px-3 py-1 text-xs font-bold text-amber-800">{{ $type->cost }}</span>@endif
                                </span>
                                <x-icon name="chevron-down" class="size-5 text-slate-400 transition duration-300" ::class="open && 'rotate-180'" />
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="grid gap-6 border-t border-slate-100 p-6 md:grid-cols-3">
                                    <div class="md:col-span-2">
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Persyaratan</p>
                                        @php $reqs = array_filter(explode("\n", (string) $type->requirements)); @endphp
                                        @if ($reqs)
                                            <ul class="mt-3 space-y-2">
                                                @foreach ($reqs as $req)
                                                    <li class="flex gap-2 text-slate-700"><x-icon name="check" class="mt-0.5 size-4 text-brand-600" /> {{ $req }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-3 text-slate-500">Tidak ada persyaratan khusus.</p>
                                        @endif
                                    </div>
                                    <div class="space-y-3 text-sm">
                                        <p><span class="text-slate-400">Jangka waktu:</span> <b class="text-slate-800">{{ $type->duration ?: '-' }}</b></p>
                                        <p><span class="text-slate-400">Biaya:</span> <b class="text-slate-800">{{ $type->cost ?: '-' }}</b></p>
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
