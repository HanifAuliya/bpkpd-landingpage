<div>
    <x-admin.page-header title="Pesan Masuk" description="Pesan dari formulir kontak di website." />

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="card overflow-hidden xl:col-span-2">
            <div class="border-b border-slate-100 p-4">
                <div class="relative">
                    <x-icon name="search" class="absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-slate-400" />
                    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari pesan..." class="form-input !pl-10">
                </div>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($messages as $msg)
                    <li wire:key="msg-{{ $msg->id }}">
                        <button wire:click="open({{ $msg->id }})" class="flex w-full items-start gap-3 p-4 text-left transition {{ $selectedId === $msg->id ? 'bg-brand-50' : 'hover:bg-slate-50' }}">
                            <span class="grid size-10 shrink-0 place-items-center rounded-full {{ $msg->read_at ? 'bg-slate-100 text-slate-500' : 'bg-brand-600 text-white' }} font-bold">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            <span class="min-w-0 flex-1">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="truncate {{ $msg->read_at ? 'font-semibold text-slate-600' : 'font-extrabold text-slate-900' }}">{{ $msg->name }}</span>
                                    <span class="shrink-0 text-xs text-slate-400">{{ $msg->created_at->diffForHumans(short: true) }}</span>
                                </span>
                                <span class="block truncate text-sm text-slate-500">{{ $msg->subject ?: \Illuminate\Support\Str::limit($msg->body, 60) }}</span>
                            </span>
                        </button>
                    </li>
                @empty
                    <li class="p-12 text-center text-slate-400"><x-icon name="inbox" class="mx-auto size-10 text-slate-300" /><p class="mt-3">Belum ada pesan.</p></li>
                @endforelse
            </ul>
            @if ($messages->hasPages())<div class="border-t border-slate-100 p-4">{{ $messages->links() }}</div>@endif
        </div>

        <div class="xl:col-span-3">
            @if ($selected)
                <div class="card p-8" wire:key="detail-{{ $selected->id }}">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">{{ $selected->subject ?: 'Tanpa subjek' }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $selected->created_at->translatedFormat('l, d F Y H:i') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="markUnread({{ $selected->id }})" class="btn-outline !py-2 text-xs">Tandai belum dibaca</button>
                            <button wire:click="delete({{ $selected->id }})" wire:confirm="Hapus pesan ini?" class="btn !py-2 text-xs text-rose-600 hover:bg-rose-50"><x-icon name="trash" class="size-4" /> Hapus</button>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-6 rounded-2xl bg-slate-50 p-4 text-sm">
                        <p class="flex items-center gap-2"><x-icon name="user" class="size-4 text-brand-600" /> {{ $selected->name }}</p>
                        <p class="flex items-center gap-2"><x-icon name="mail" class="size-4 text-brand-600" /> {{ $selected->email }}</p>
                        @if ($selected->phone)<p class="flex items-center gap-2"><x-icon name="phone" class="size-4 text-brand-600" /> {{ $selected->phone }}</p>@endif
                    </div>
                    <p class="mt-6 whitespace-pre-line leading-7 text-slate-700">{{ $selected->body }}</p>
                    <a href="mailto:{{ $selected->email }}?subject={{ rawurlencode('Re: '.($selected->subject ?: 'Pesan Anda')) }}" class="btn-primary mt-8"><x-icon name="send" class="size-4" /> Balas lewat email</a>
                </div>
            @else
                <div class="card grid h-full min-h-80 place-items-center p-8 text-center text-slate-400">
                    <div><x-icon name="mail" class="mx-auto size-12 text-slate-300" /><p class="mt-3">Pilih pesan untuk membaca.</p></div>
                </div>
            @endif
        </div>
    </div>
</div>
