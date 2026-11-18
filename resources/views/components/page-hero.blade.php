@props(['title', 'eyebrow' => null, 'subtitle' => null, 'crumbs' => []])
<section class="relative overflow-hidden bg-ink pb-20 pt-36 text-white sm:pb-24 sm:pt-44">
    <div class="bg-grid absolute inset-0 [mask-image:radial-gradient(ellipse_at_top,black,transparent_75%)]"></div>
    <div class="absolute -left-24 top-10 size-96 animate-blob rounded-full bg-brand-600/30 blur-3xl"></div>
    <div class="absolute -right-24 bottom-0 size-80 animate-blob rounded-full bg-gold-500/15 blur-3xl [animation-delay:-6s]"></div>
    <div class="container-x relative">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-white/60" aria-label="Breadcrumb" data-reveal="up">
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 hover:text-white"><x-icon name="home" class="size-4" /> Beranda</a>
            @foreach ($crumbs as $label => $url)
                <x-icon name="chevron-right" class="size-3.5" />
                @if ($url)<a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>@else<span class="text-white">{{ $label }}</span>@endif
            @endforeach
        </nav>
        @if ($eyebrow)
            <p class="mt-8 text-xs font-bold uppercase tracking-[0.25em] text-gold-400" data-reveal="up" style="--delay:80ms">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-4xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl" data-reveal="up" style="--delay:140ms">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-5 max-w-2xl text-lg leading-8 text-white/70" data-reveal="up" style="--delay:200ms">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
