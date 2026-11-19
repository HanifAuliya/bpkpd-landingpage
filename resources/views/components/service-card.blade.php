@props(['service', 'delay' => 0])
{{-- Kartu layanan online: putih, berubah gradasi gelap saat disorot --}}
<a href="{{ $service->url }}" target="_blank" rel="noopener" data-reveal="up" style="--delay: {{ $delay }}ms"
   class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 transition duration-500 hover:-translate-y-2 hover:border-transparent hover:shadow-2xl hover:shadow-brand-900/15 dark:border-navy-800 dark:bg-navy-900">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-700 to-ink opacity-0 transition duration-500 group-hover:opacity-100"></div>
    <div class="bg-lines absolute inset-0 opacity-0 transition duration-500 group-hover:opacity-100"></div>
    <div class="relative">
        <div class="flex items-start justify-between">
            <span class="grid size-14 place-items-center rounded-2xl bg-brand-50 text-brand-600 transition duration-500 group-hover:rotate-6 group-hover:bg-gold-400 group-hover:text-ink dark:bg-brand-950 dark:text-brand-300">
                <x-icon :name="$service->icon" class="size-6" />
            </span>
            <span class="grid size-10 place-items-center rounded-full border border-slate-200 text-slate-400 transition duration-500 group-hover:rotate-45 group-hover:border-white/20 group-hover:text-white dark:border-navy-700">
                <x-icon name="arrow-up-right" class="size-4" />
            </span>
        </div>
        <h3 class="mt-8 text-xl font-extrabold text-navy-900 transition group-hover:text-white dark:text-white">{{ $service->title }}</h3>
        <p class="mt-3 leading-7 text-slate-500 transition group-hover:text-white/70 dark:text-navy-300">{{ $service->description }}</p>
    </div>
</a>
