<x-layouts.public title="Profil">
    <x-page-hero eyebrow="Profil Instansi" :title="setting('nama_dinas')" :subtitle="setting('daerah')" :crumbs="['Profil' => null]" />

    <section class="py-16 sm:py-20">
        <div class="container-x grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-7">
                <x-section-heading eyebrow="Tentang" title="Siapa kami" />
                <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-navy-300" data-reveal="up">{{ setting('deskripsi') }}</p>

                <div class="mt-14" id="tugas" data-reveal="up">
                    <span class="eyebrow">Tugas Pokok</span>
                    <p class="mt-5 rounded-xl border-l-4 border-gold-500 bg-slate-50 p-6 text-lg leading-8 text-slate-700 dark:bg-navy-900 dark:text-navy-100">{{ setting('tugas') }}</p>
                </div>

                <div class="mt-14" id="fungsi">
                    <span class="eyebrow" data-reveal="up">Fungsi</span>
                    <ol class="card mt-5 divide-y divide-slate-100 dark:divide-navy-800">
                        @foreach (array_values(array_filter(explode("\n", (string) setting('fungsi')))) as $i => $fungsi)
                            <li class="flex gap-5 p-5" data-reveal="up" style="--delay: {{ $i * 50 }}ms">
                                <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-brand-50 text-sm font-extrabold text-brand-700 dark:bg-brand-950 dark:text-brand-300">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="pt-1 leading-7 text-slate-700 dark:text-navy-200">{{ $fungsi }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <aside class="lg:col-span-5">
                <div class="sticky top-28 space-y-5">
                    <div id="visi-misi" class="scroll-mt-28 rounded-xl bg-navy-900 p-7 text-white dark:border dark:border-navy-800" data-reveal="up">
                        <p class="flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-gold-300"><span class="h-0.5 w-6 bg-gold-400"></span>Visi</p>
                        <p class="mt-3 text-xl font-extrabold leading-snug">&ldquo;{{ setting('visi') }}&rdquo;</p>
                        <p class="mt-8 flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-gold-300"><span class="h-0.5 w-6 bg-gold-400"></span>Misi</p>
                        <ul class="mt-4 space-y-3">
                            @foreach (array_filter(explode("\n", (string) setting('misi'))) as $misi)
                                <li class="flex gap-3 leading-7 text-navy-100"><x-icon name="check" class="mt-1.5 size-4 text-gold-400" />{{ $misi }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="grid grid-cols-2 gap-4" data-reveal="up" style="--delay:100ms">
                        @foreach ([['profil.struktur', 'chart', 'Struktur Organisasi'], ['profil.pegawai', 'users', 'Data Pegawai']] as [$r, $icon, $label])
                            <a href="{{ route($r) }}" class="card card-hover group p-5">
                                <x-icon :name="$icon" class="size-6 text-brand-700 dark:text-brand-400" />
                                <p class="mt-3 font-bold text-navy-900 dark:text-white">{{ $label }}</p>
                                <span class="mt-1 inline-flex items-center gap-1 text-sm font-semibold text-brand-700 dark:text-brand-300">Lihat <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-0.5" /></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>
