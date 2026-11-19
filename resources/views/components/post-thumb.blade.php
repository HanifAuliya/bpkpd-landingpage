@props(['post'])
{{-- Gambar berita, atau sampul duotone dari foto gedung bila berita belum punya foto --}}
@if ($post->image)
    <img src="{{ media($post->image) }}" alt="" loading="lazy" {{ $attributes->merge(['class' => 'size-full object-cover']) }}>
@else
    @php $crop = ['object-[20%_30%]', 'object-[62%_70%]', 'object-[80%_40%]', 'object-[35%_85%]', 'object-[55%_20%]'][$post->id % 5]; @endphp
    <div {{ $attributes->merge(['class' => 'relative size-full overflow-hidden bg-navy-900']) }}>
        <img src="{{ asset('images/gedung-bpkpd-sm.jpg') }}" alt="" loading="lazy" class="size-full scale-110 object-cover opacity-40 grayscale {{ $crop }}">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900/70 via-navy-900/40 to-brand-800/70"></div>
        <span class="absolute left-4 top-4 flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-gold-300">
            <span class="h-0.5 w-5 bg-gold-400"></span>{{ setting('nama_singkat', 'BPKPD') }} HST
        </span>
    </div>
@endif
