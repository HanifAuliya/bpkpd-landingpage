@props(['eyebrow', 'title', 'subtitle' => null, 'center' => false, 'number' => null])
<div {{ $attributes->class(['max-w-2xl', 'mx-auto text-center' => $center]) }} data-reveal="up">
    <span class="eyebrow">@if ($number)<span class="text-gold-600 dark:text-gold-400">{{ $number }}</span><span class="text-slate-300 dark:text-navy-600">/</span>@endif{{ $eyebrow }}</span>
    <h2 class="section-title">{!! $title !!}</h2>
    @if ($subtitle)<p class="mt-3 text-lg leading-8 text-slate-600 dark:text-navy-300">{{ $subtitle }}</p>@endif
</div>
