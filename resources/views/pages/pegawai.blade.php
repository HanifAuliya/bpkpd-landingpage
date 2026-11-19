<x-layouts.public title="Data Pegawai">
    <x-page-hero eyebrow="Profil" title="Data Pegawai" subtitle="Aparatur yang melayani masyarakat di {{ setting('nama_singkat') }} {{ setting('daerah') }}." :crumbs="['Profil' => route('profil'), 'Data Pegawai' => null]" />

    <section class="py-16 sm:py-20" x-data="{ q: '' }">
        <div class="container-x">
            <div class="relative mx-auto max-w-md">
                <x-icon name="search" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                <label for="cari-pegawai" class="sr-only">Cari pegawai</label>
                <input id="cari-pegawai" x-model="q" type="search" placeholder="Cari nama atau jabatan..." class="form-input !py-3 !pl-12">
            </div>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($employees as $i => $e)
                    <div x-show="q === '' || @js(strtolower($e->name.' '.$e->position)).includes(q.toLowerCase())"
                         class="card overflow-hidden text-center" data-reveal="up" style="--delay: {{ ($i % 8) * 50 }}ms">
                        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-navy-800">
                            @if ($e->photo)
                                <img src="{{ media($e->photo) }}" alt="{{ $e->name }}" loading="lazy" class="size-full object-cover object-top">
                            @else
                                <div class="grid size-full place-items-center">
                                    <span class="grid size-24 place-items-center rounded-full border-4 border-white bg-brand-700 text-3xl font-extrabold text-white shadow dark:border-navy-900">
                                        {{ collect(explode(' ', preg_replace('/[^A-Za-z ]/', '', strtok($e->name, ','))))->filter()->take(2)->map(fn ($w) => $w[0])->join('') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="border-t-4 border-gold-500 p-5">
                            <p class="font-extrabold text-navy-900 dark:text-white">{{ $e->name }}</p>
                            <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-navy-300">{{ $e->position }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
