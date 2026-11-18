@props(['eyebrow', 'title', 'subtitle' => null, 'center' => false])
<div {{ $attributes->class(['max-w-2xl', 'mx-auto text-center' => $center]) }} data-reveal="up">
    <span class="eyebrow"><span class="size-1.5 rounded-full bg-brand-500"></span>{{ $eyebrow }}</span>
    <h2 class="section-title">{!! $title !!}</h2>
    @if ($subtitle)<p class="mt-4 text-lg leading-8 text-slate-500">{{ $subtitle }}</p>@endif
</div>
