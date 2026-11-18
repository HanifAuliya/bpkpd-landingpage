@if (setting('logo'))
    <img src="{{ media(setting('logo')) }}" alt="Logo {{ setting('nama_singkat') }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
@else
    <svg viewBox="0 0 48 48" {{ $attributes }} aria-hidden="true">
        <defs>
            <linearGradient id="lg-a" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#34d399"/><stop offset="1" stop-color="#047857"/></linearGradient>
        </defs>
        <rect width="48" height="48" rx="14" fill="url(#lg-a)"/>
        <path d="M14 33V20l10-6 10 6v13" fill="none" stroke="#fff" stroke-width="2.6" stroke-linejoin="round"/>
        <path d="M19 33v-8M24 33v-11M29 33v-6" stroke="#f8c14a" stroke-width="2.6" stroke-linecap="round"/>
    </svg>
@endif
