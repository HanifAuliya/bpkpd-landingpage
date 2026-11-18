<div class="max-w-3xl">
    <x-admin.page-header title="Akun Saya" description="Ubah nama, email, dan password Anda." />

    <form wire:submit="saveProfile" class="card p-6 sm:p-8">
        <h2 class="font-extrabold text-slate-900">Profil</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div><label class="form-label">Nama</label><input wire:model="name" class="form-input">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">Email</label><input type="email" wire:model="email" class="form-input">@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
        </div>
        <button class="btn-primary mt-6">Simpan profil</button>
    </form>

    <form wire:submit="savePassword" class="card mt-6 p-6 sm:p-8">
        <h2 class="font-extrabold text-slate-900">Ganti password</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2"><label class="form-label">Password saat ini</label><input type="password" wire:model="current_password" class="form-input" autocomplete="current-password">@error('current_password')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">Password baru</label><input type="password" wire:model="password" class="form-input" autocomplete="new-password">@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">Ulangi password baru</label><input type="password" wire:model="password_confirmation" class="form-input" autocomplete="new-password"></div>
        </div>
        <button class="btn-primary mt-6">Ganti password</button>
    </form>
</div>
