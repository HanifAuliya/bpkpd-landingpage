<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Users extends Resource
{
    public string $title = 'Pengguna';

    public string $singular = 'Pengguna';

    public string $description = 'Akun yang bisa masuk ke CMS.';

    protected array $searchable = ['name', 'email'];

    protected string $orderBy = 'name';

    protected function model(): string
    {
        return User::class;
    }

    protected function columns(): array
    {
        return [
            'name' => ['label' => 'Nama', 'sub' => 'email'],
            'created_at' => ['label' => 'Dibuat', 'type' => 'date'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama', 'required' => true],
            'email' => ['label' => 'Email', 'type' => 'email', 'required' => true, 'rules' => [Rule::unique('users', 'email')->ignore($this->editingId)]],
            'password' => ['label' => 'Password', 'type' => 'password', 'required' => true, 'hint' => $this->editingId ? 'Kosongkan jika tidak ingin mengganti.' : 'Minimal 8 karakter.'],
        ];
    }

    protected function beforeSave(array $data, ?Model $record): array
    {
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        return $data;
    }

    public function delete(int $id): void
    {
        if ($id === auth()->id()) {
            $this->dispatch('toast', message: 'Tidak bisa menghapus akun sendiri.', type: 'error');

            return;
        }
        parent::delete($id);
    }
}
