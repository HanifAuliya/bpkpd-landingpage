<x-layouts.public title="Data Pegawai">
    <x-page-hero eyebrow="Profil" title="Data Pegawai" subtitle="Aparatur yang melayani masyarakat di {{ setting('nama_singkat') }} {{ setting('daerah') }}." :crumbs="['Profil' => route('profil'), 'Data Pegawai' => null]" />

    <section class="py-24" x-data="{ q: '' }">
        <div class="container-x">
            <div class="relative mx-auto max-w-md" data-reveal="up">
                <x-icon name="search" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                <input x-model="q" type="search" placeholder="Cari nama atau jabatan..." class="form-input !rounded-full !py-3.5 !pl-12">
            </div>
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($employees as $i => $e)
                    <div x-show="q === '' || @js(strtolower($e->name.' '.$e->position)).includes(q.toLowerCase())" x-transition
                         class="card card-hover group overflow-hidden text-center" data-reveal="up" style="--delay: {{ ($i % 8) * 60 }}ms">
                        <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-br from-brand-100 to-brand-50">
                            @if ($e->photo)
                                <img src="{{ media($e->photo) }}" alt="{{ $e->name }}" loading="lazy" class="size-full object-cover object-top transition duration-700 group-hover:scale-105">
                            @else
                                <div class="grid size-full place-items-center">
                                    <span class="grid size-24 place-items-center rounded-full bg-white text-3xl font-extrabold text-brand-600 shadow-lg transition duration-500 group-hover:scale-110">
                                        {{ collect(explode(' ', preg_replace('/[^A-Za-z ]/', '', strtok($e->name, ','))))->filter()->take(2)->map(fn ($w) => $w[0])->join('') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="font-extrabold text-slate-900">{{ $e->name }}</p>
                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $e->position }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
