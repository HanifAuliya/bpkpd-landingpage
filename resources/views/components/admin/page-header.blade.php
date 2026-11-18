@props(['title', 'description' => null])
<div class="mb-8 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h1>
        @if ($description)<p class="mt-1 text-slate-500">{{ $description }}</p>@endif
    </div>
    <div class="flex flex-wrap gap-2">{{ $slot }}</div>
</div>
