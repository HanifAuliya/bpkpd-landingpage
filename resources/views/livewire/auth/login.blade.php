<div class="relative grid min-h-screen overflow-hidden lg:grid-cols-2">
    <div class="bg-grid absolute inset-0"></div>
    <div class="absolute -left-40 top-1/4 size-[36rem] animate-blob rounded-full bg-brand-600/30 blur-3xl"></div>
    <div class="absolute bottom-0 right-1/3 size-[26rem] animate-blob rounded-full bg-gold-500/15 blur-3xl [animation-delay:-7s]"></div>

    <div class="relative hidden flex-col justify-between p-12 text-white lg:flex">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <x-logo class="size-11" />
            <span class="font-extrabold">{{ setting('nama_singkat') }}<span class="text-gold-400">.</span></span>
        </a>
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Content Management System</p>
            <h1 class="mt-4 max-w-md text-5xl font-extrabold leading-tight">Kelola website dengan <span class="text-gradient">mudah</span>.</h1>
            <p class="mt-5 max-w-md text-white/60">{{ setting('nama_dinas') }} {{ setting('daerah') }}</p>
        </div>
        <p class="text-sm text-white/40">&copy; {{ date('Y') }} {{ setting('nama_singkat') }}</p>
    </div>

    <div class="relative flex items-center justify-center p-6">
        <div class="w-full max-w-md rounded-[2rem] border border-white/10 bg-white p-8 shadow-2xl sm:p-10" data-reveal="zoom">
            <x-logo class="size-12 lg:hidden" />
            <h2 class="mt-4 text-2xl font-extrabold text-slate-900 lg:mt-0">Masuk ke CMS</h2>
            <p class="mt-1 text-slate-500">Gunakan akun admin Anda.</p>

            <form wire:submit="login" class="mt-8 space-y-5">
                <div>
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" wire:model="email" class="form-input" autocomplete="username" autofocus>
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div x-data="{ show: false }">
                    <label class="form-label" for="password">Password</label>
                    <div class="relative">
                        <input id="password" :type="show ? 'text' : 'password'" wire:model="password" class="form-input !pr-12" autocomplete="current-password">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Tampilkan password"><x-icon name="eye" class="size-5" /></button>
                    </div>
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" wire:model="remember" class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"> Ingat saya
                </label>
                <button type="submit" class="btn-primary w-full !py-3.5" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="login">Masuk</span>
                    <span wire:loading wire:target="login">Memeriksa...</span>
                    <x-icon name="arrow-right" class="size-4" />
                </button>
            </form>
            <a href="{{ route('home') }}" class="mt-8 flex items-center justify-center gap-2 text-sm font-semibold text-slate-500 hover:text-brand-700"><x-icon name="chevron-left" class="size-4" /> Kembali ke website</a>
        </div>
    </div>
</div>
