<div>
    <x-page-hero eyebrow="Hubungi Kami" title="Kami siap membantu" subtitle="Sampaikan pertanyaan, saran, atau pengaduan seputar layanan kami." :crumbs="['Kontak' => null]" />

    <section class="py-14 sm:py-16">
        <div class="container-x grid gap-10 lg:grid-cols-12">
            <div class="space-y-4 lg:col-span-5">
                @foreach ([
                    ['map-pin', 'Alamat', setting('alamat'), null],
                    ['mail', 'Email', setting('email'), setting('email') ? 'mailto:'.setting('email') : null],
                    ['phone', 'Telepon', setting('telepon'), setting('telepon') ? 'tel:'.preg_replace('/\D/', '', setting('telepon')) : null],
                    ['clock', 'Jam Pelayanan', nl2br(e(setting('jam_layanan'))), null],
                ] as $i => [$icon, $label, $value, $href])
                    @continue(blank($value))
                    <div class="card flex gap-5 p-5" data-reveal="up" style="--delay: {{ $i * 80 }}ms">
                        <span class="grid size-11 shrink-0 place-items-center rounded-lg bg-brand-50 text-brand-700 dark:bg-brand-950 dark:text-brand-300"><x-icon :name="$icon" /></span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-500 dark:text-navy-400">{{ $label }}</p>
                            @if ($href)<a href="{{ $href }}" class="mt-1 block font-semibold text-navy-900 hover:text-brand-700 dark:text-white dark:hover:text-brand-300">{{ $value }}</a>@else<p class="mt-1 font-semibold leading-7 text-navy-900 dark:text-white">{!! $icon === 'clock' ? $value : e($value) !!}</p>@endif
                        </div>
                    </div>
                @endforeach
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-navy-800" data-reveal="up" style="--delay:320ms">
                    <iframe title="Peta lokasi" src="https://maps.google.com/maps?q={{ urlencode(setting('maps_query', setting('alamat'))) }}&z=16&output=embed" class="h-72 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="lg:col-span-7" data-reveal="up">
                <div class="card relative overflow-hidden border-t-4 !border-t-brand-700 p-7 sm:p-10">
                    @if ($sent)
                        <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="py-16 text-center">
                            <span class="mx-auto grid size-20 place-items-center rounded-full bg-brand-50 text-brand-700 dark:bg-brand-950 dark:text-brand-300"><x-icon name="check" class="size-10" /></span>
                            <h2 class="mt-6 text-2xl font-extrabold text-navy-900 dark:text-white">Pesan terkirim!</h2>
                            <p class="mt-2 text-slate-600 dark:text-navy-300">Terima kasih. Tim kami akan menindaklanjuti pesan Anda.</p>
                            <button wire:click="$set('sent', false)" class="btn-outline mt-8">Kirim pesan lain</button>
                        </div>
                    @else
                        <h2 class="text-2xl font-extrabold text-navy-900 dark:text-white">Kirim pesan</h2>
                        <p class="mt-2 text-slate-600 dark:text-navy-300">Isi formulir berikut dan kami akan membalas melalui email.</p>
                        <form wire:submit="send" class="mt-8 grid gap-5 sm:grid-cols-2">
                            <input type="text" wire:model="website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
                            <div>
                                <label class="form-label" for="name">Nama lengkap</label>
                                <input id="name" wire:model="name" class="form-input" autocomplete="name">
                                @error('name')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="email">Email</label>
                                <input id="email" type="email" wire:model="email" class="form-input" autocomplete="email">
                                @error('email')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="phone">No. telepon / WhatsApp <span class="font-normal text-slate-400 dark:text-navy-400">(opsional)</span></label>
                                <input id="phone" wire:model="phone" class="form-input" autocomplete="tel">
                                @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="subject">Subjek <span class="font-normal text-slate-400 dark:text-navy-400">(opsional)</span></label>
                                <input id="subject" wire:model="subject" class="form-input">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label" for="body">Pesan</label>
                                <textarea id="body" wire:model="body" rows="6" class="form-input"></textarea>
                                @error('body')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <button type="submit" class="btn-primary !px-7 !py-3" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="send">Kirim Pesan</span>
                                    <span wire:loading wire:target="send">Mengirim...</span>
                                    <x-icon name="send" class="size-4" />
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
