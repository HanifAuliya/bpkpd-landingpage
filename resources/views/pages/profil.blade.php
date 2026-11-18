<x-layouts.public title="Profil">
    <x-page-hero eyebrow="Profil Instansi" :title="setting('nama_dinas')" :subtitle="setting('daerah')" :crumbs="['Profil' => null]" />

    <section class="py-24">
        <div class="container-x grid gap-16 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <x-section-heading eyebrow="Tentang" title="Siapa kami" />
                <p class="mt-6 text-lg leading-8 text-slate-600" data-reveal="up">{{ setting('deskripsi') }}</p>

                <div class="mt-16" id="tugas" data-reveal="up">
                    <span class="eyebrow">Tugas Pokok</span>
                    <p class="mt-5 rounded-3xl border-l-4 border-brand-500 bg-brand-50/60 p-7 text-lg leading-8 text-slate-700">{{ setting('tugas') }}</p>
                </div>

                <div class="mt-16" id="fungsi">
                    <span class="eyebrow" data-reveal="up">Fungsi</span>
                    <ol class="mt-6 space-y-3">
                        @foreach (array_values(array_filter(explode("\n", (string) setting('fungsi')))) as $i => $fungsi)
                            <li class="group flex gap-5 rounded-2xl border border-slate-200 bg-white p-5 transition duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-900/5" data-reveal="up" style="--delay: {{ $i * 60 }}ms">
                                <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-50 font-extrabold text-brand-700 transition group-hover:bg-brand-600 group-hover:text-white">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="pt-2 leading-7 text-slate-700">{{ $fungsi }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <aside class="lg:col-span-5">
                <div class="sticky top-28 space-y-6">
                    <div id="visi-misi" class="scroll-mt-28 overflow-hidden rounded-[2rem] bg-ink p-8 text-white shadow-2xl" data-reveal="left">
                        <div class="bg-grid pointer-events-none absolute"></div>
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Visi</p>
                        <p class="mt-3 text-2xl font-extrabold leading-snug">&ldquo;{{ setting('visi') }}&rdquo;</p>
                        <p class="mt-10 text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Misi</p>
                        <ul class="mt-4 space-y-4">
                            @foreach (array_filter(explode("\n", (string) setting('misi'))) as $misi)
                                <li class="flex gap-3 text-white/80"><span class="mt-1 grid size-5 shrink-0 place-items-center rounded-full bg-brand-500 text-ink"><x-icon name="check" class="size-3" /></span>{{ $misi }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="grid grid-cols-2 gap-4" data-reveal="left" style="--delay:120ms">
                        <a href="{{ route('profil.struktur') }}" class="card card-hover group p-6">
                            <x-icon name="chart" class="size-7 text-brand-600" />
                            <p class="mt-4 font-bold text-slate-900">Struktur Organisasi</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">Lihat <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" /></span>
                        </a>
                        <a href="{{ route('profil.pegawai') }}" class="card card-hover group p-6">
                            <x-icon name="users" class="size-7 text-brand-600" />
                            <p class="mt-4 font-bold text-slate-900">Data Pegawai</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">Lihat <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" /></span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>
