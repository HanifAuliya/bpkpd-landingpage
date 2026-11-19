@if (setting('logo'))
    <img src="{{ media(setting('logo')) }}" alt="Logo {{ setting('nama_singkat') }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
@else
    {{-- Lambang sementara sampai logo resmi diunggah lewat CMS (menu Profil) --}}
    <svg viewBox="0 0 48 48" {{ $attributes }} aria-hidden="true">
        <rect width="48" height="48" rx="11" fill="#187a71"/>
        <path d="M11 37h26" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
        <path d="M15 33v-5M21 33v-8M27 33v-11M33 33v-14" stroke="#fff" stroke-width="3.2" stroke-linecap="round"/>
        <path d="M12 25c7-1 13-5 20-13" fill="none" stroke="#ddb243" stroke-width="2.8" stroke-linecap="round"/>
        <path d="M26.5 11.5 33 11l-.6 6.4" fill="none" stroke="#ddb243" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
@endif
