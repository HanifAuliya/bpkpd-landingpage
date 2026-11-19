@props(['title', 'eyebrow' => null, 'subtitle' => null, 'crumbs' => []])
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    <img src="{{ asset('images/gedung-bpkpd-sm.jpg') }}" alt="" class="absolute inset-y-0 right-0 -z-20 h-full w-full animate-kenburns object-cover object-[65%_40%] opacity-35 lg:w-2/3">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/90 to-navy-950/40"></div>
    <div class="bg-lines absolute inset-0 -z-10 [mask-image:linear-gradient(90deg,black,transparent_70%)]"></div>
    <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-brand-500 via-gold-400 to-transparent"></div>
    <div class="container-x py-14 sm:py-20">
        <nav class="glass inline-flex flex-wrap items-center gap-2 rounded-full px-4 py-1.5 text-sm text-navy-200" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 hover:text-white"><x-icon name="home" class="size-4" /> Beranda</a>
            @foreach ($crumbs as $label => $url)
                <x-icon name="chevron-right" class="size-3.5 text-white/40" />
                @if ($url)<a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>@else<span class="text-white" aria-current="page">{{ $label }}</span>@endif
            @endforeach
        </nav>
        @if ($eyebrow)
            <p class="mt-8 flex items-center gap-3 text-xs font-bold uppercase tracking-[0.25em] text-gold-300"><span class="h-px w-10 bg-gold-400"></span>{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-4 max-w-4xl text-3xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-5 max-w-2xl text-lg leading-8 text-navy-200">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
