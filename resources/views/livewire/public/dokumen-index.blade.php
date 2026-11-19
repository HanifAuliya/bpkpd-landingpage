<div>
    <x-page-hero eyebrow="Informasi Publik" title="Dokumen" subtitle="Unduh dokumen perencanaan, laporan, dan regulasi." :crumbs="['Dokumen' => null]" />

    <section class="py-14 sm:py-16">
        <div class="container-x">
            <div class="card grid gap-3 p-4 sm:grid-cols-4">
                <div class="relative sm:col-span-2">
                    <x-icon name="search" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                    <label for="cari-dokumen" class="sr-only">Cari dokumen</label>
                    <input id="cari-dokumen" wire:model.live.debounce.400ms="search" type="search" placeholder="Cari nama dokumen..." class="form-input !pl-12">
                </div>
                <select wire:model.live="jenis" class="form-input" aria-label="Jenis dokumen">
                    <option value="">Semua jenis</option>
                    @foreach ($types as $t)<option value="{{ $t }}">{{ $t }}</option>@endforeach
                </select>
                <select wire:model.live="tahun" class="form-input" aria-label="Tahun dokumen">
                    <option value="">Semua tahun</option>
                    @foreach ($years as $y)<option value="{{ $y }}">{{ $y }}</option>@endforeach
                </select>
            </div>

            <div class="card mt-6 divide-y divide-slate-100 dark:divide-navy-800" wire:loading.class="opacity-50">
                @forelse ($documents as $doc)
                    <div wire:key="doc-{{ $doc->id }}" class="flex flex-wrap items-center gap-5 p-5">
                        <span class="grid size-12 shrink-0 place-items-center rounded-lg bg-brand-50 text-brand-700 dark:bg-brand-950 dark:text-brand-300"><x-icon name="file" /></span>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-navy-900 dark:text-white">{{ $doc->name }}</p>
                            <p class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                                @if ($doc->type)<span class="rounded bg-slate-100 px-2 py-0.5 font-semibold text-slate-600 dark:bg-navy-800 dark:text-navy-200">{{ $doc->type }}</span>@endif
                                @if ($doc->year)<span class="rounded bg-brand-50 px-2 py-0.5 font-semibold text-brand-800 dark:bg-brand-950 dark:text-brand-300">{{ $doc->year }}</span>@endif
                                <span class="text-slate-500 dark:text-navy-400">{{ number_format($doc->downloads) }}x diunduh</span>
                            </p>
                        </div>
                        <a href="{{ route('dokumen.unduh', $doc) }}" class="btn-primary !py-2">Unduh <x-icon name="download" class="size-4" /></a>
                    </div>
                @empty
                    <div class="p-16 text-center text-slate-500 dark:text-navy-300">
                        <x-icon name="file" class="mx-auto size-10 text-slate-300 dark:text-navy-600" />
                        <p class="mt-4">Belum ada dokumen yang cocok.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-10">{{ $documents->links() }}</div>
        </div>
    </section>
</div>
