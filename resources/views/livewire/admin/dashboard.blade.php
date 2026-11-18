<div>
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 via-brand-700 to-ink p-8 text-white shadow-xl shadow-brand-900/10">
        <div class="bg-grid absolute inset-0"></div>
        <div class="absolute -right-10 -top-10 size-60 animate-blob rounded-full bg-gold-400/30 blur-3xl"></div>
        <div class="relative flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-sm font-semibold text-brand-100">Selamat datang kembali,</p>
                <h1 class="mt-1 text-3xl font-extrabold">{{ auth()->user()->name }} 👋</h1>
                <p class="mt-2 max-w-lg text-white/70">Kelola seluruh konten website {{ setting('nama_singkat') }} dari sini.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.posts') }}" wire:navigate class="btn-gold"><x-icon name="plus" class="size-4" /> Tulis berita</a>
                <a href="{{ route('home') }}" target="_blank" class="btn-ghost">Lihat website</a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($stats as [$label, $value, $icon, $route])
            <a href="{{ route($route) }}" wire:navigate class="card card-hover group flex items-center gap-5 p-6">
                <span class="grid size-14 place-items-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white"><x-icon :name="$icon" class="size-6" /></span>
                <div>
                    <p class="text-3xl font-extrabold text-slate-900" x-data="counter({{ $value }}, 900)" x-text="value">{{ $value }}</p>
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-extrabold text-slate-900">Berita terpopuler</h2>
                <span class="text-sm text-slate-400">{{ number_format($totalViews) }} total dibaca</span>
            </div>
            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($popular as $i => $post)
                    <li class="flex items-center gap-4 py-3">
                        <span class="grid size-8 place-items-center rounded-lg bg-slate-100 text-sm font-bold text-slate-500">{{ $i + 1 }}</span>
                        <span class="flex-1 truncate font-semibold text-slate-700">{{ $post->title }}</span>
                        <span class="flex items-center gap-1 text-sm text-slate-400"><x-icon name="eye" class="size-4" /> {{ number_format($post->views) }}</span>
                    </li>
                @empty
                    <li class="py-6 text-center text-slate-400">Belum ada berita.</li>
                @endforelse
            </ul>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-extrabold text-slate-900">Pesan terbaru</h2>
                <a href="{{ route('admin.messages') }}" wire:navigate class="text-sm font-semibold text-brand-700">Lihat semua</a>
            </div>
            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($messages as $msg)
                    <li class="flex items-start gap-4 py-3">
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-brand-50 text-sm font-bold text-brand-700">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="flex items-center gap-2 font-semibold text-slate-800">{{ $msg->name }} @unless($msg->read_at)<span class="size-2 rounded-full bg-gold-400"></span>@endunless</p>
                            <p class="truncate text-sm text-slate-500">{{ $msg->subject ?: $msg->body }}</p>
                        </div>
                        <span class="text-xs text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="py-6 text-center text-slate-400">Belum ada pesan.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <p class="mt-6 text-center text-xs text-slate-400">Dokumen telah diunduh {{ number_format($totalDownloads) }} kali.</p>
</div>
