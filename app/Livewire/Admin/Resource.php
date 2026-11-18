<?php

namespace App\Livewire\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/**
 * Dasar untuk semua modul CMS yang berbentuk daftar + formulir (CRUD).
 *
 * Subclass cukup menentukan model, kolom tabel, dan field formulir.
 * Tipe field: text, textarea, richtext, number, url, email, date, datetime,
 * toggle, select, icon, image, file, password.
 */
#[Layout('components.layouts.admin')]
abstract class Resource extends Component
{
    use WithFileUploads, WithPagination;

    public string $title = '';

    public string $singular = '';

    public string $description = '';

    /** Panel formulir lebar (untuk editor teks). */
    public bool $wide = false;

    #[Url(except: '')]
    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public array $form = [];

    public array $uploads = [];

    /** Kolom untuk pencarian. */
    protected array $searchable = ['title'];

    protected string $orderBy = 'sort_order';

    protected string $orderDirection = 'asc';

    protected int $perPage = 10;

    /** @return class-string<Model> */
    abstract protected function model(): string;

    /** @return array<string, array{label: string, type?: string}> */
    abstract protected function columns(): array;

    /** @return array<string, array<string, mixed>> */
    abstract protected function fields(): array;

    /** Ubah data sebelum disimpan. */
    protected function beforeSave(array $data, ?Model $record): array
    {
        return $data;
    }

    protected function query(): Builder
    {
        return $this->model()::query();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        foreach ($this->fields() as $name => $field) {
            $this->form[$name] = $field['default'] ?? match ($field['type'] ?? 'text') {
                'toggle' => true,
                'number' => ($name === 'sort_order' ? ($this->model()::max('sort_order') ?? 0) + 1 : 0),
                'datetime' => now()->format('Y-m-d\TH:i'),
                default => '',
            };
        }
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->resetForm();
        $record = $this->model()::findOrFail($id);
        $this->editingId = $record->id;
        foreach ($this->fields() as $name => $field) {
            $value = $record->getAttribute($name);
            $this->form[$name] = match ($field['type'] ?? 'text') {
                'datetime' => $value?->format('Y-m-d\TH:i'),
                'date' => $value?->format('Y-m-d'),
                'password' => '',
                'toggle' => (bool) $value,
                default => $value,
            };
        }
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate($this->buildRules(), [], $this->attributeNames());

        $record = $this->editingId ? $this->model()::findOrFail($this->editingId) : null;
        $data = collect($this->fields())
            ->reject(fn ($f) => in_array($f['type'] ?? 'text', ['image', 'file']))
            ->mapWithKeys(fn ($f, $name) => [$name => blank($this->form[$name] ?? null) && ($f['type'] ?? '') !== 'toggle' ? null : $this->form[$name]])
            ->all();

        foreach ($this->fields() as $name => $field) {
            if (in_array($field['type'] ?? 'text', ['image', 'file']) && isset($this->uploads[$name])) {
                $data[$name] = $this->uploads[$name]->store($field['directory'] ?? Str::snake(class_basename($this->model())), 'public');
                if ($record?->getAttribute($name)) {
                    Storage::disk('public')->delete($record->getAttribute($name));
                }
            }
        }

        $data = $this->beforeSave($data, $record);
        $record ? $record->update($data) : $this->model()::create($data);

        $this->dispatch('toast', message: $this->singular.' berhasil '.($record ? 'diperbarui' : 'ditambahkan').'.');
        $this->showForm = false;
        $this->resetForm();
    }

    public function removeFile(string $name): void
    {
        unset($this->uploads[$name]);
        if ($this->editingId && ! ($this->fields()[$name]['required'] ?? false)) {
            $record = $this->model()::findOrFail($this->editingId);
            if ($record->getAttribute($name)) {
                Storage::disk('public')->delete($record->getAttribute($name));
                $record->update([$name => null]);
            }
        }
    }

    public function delete(int $id): void
    {
        $record = $this->model()::findOrFail($id);
        foreach ($this->fields() as $name => $field) {
            if (in_array($field['type'] ?? 'text', ['image', 'file']) && $record->getAttribute($name)) {
                Storage::disk('public')->delete($record->getAttribute($name));
            }
        }
        $record->delete();
        $this->dispatch('toast', message: $this->singular.' dihapus.');
    }

    public function toggle(int $id, string $column): void
    {
        $record = $this->model()::findOrFail($id);
        abort_unless(($this->columns()[$column]['type'] ?? null) === 'toggle', 403);
        $record->update([$column => ! $record->getAttribute($column)]);
    }

    public function moveUp(int $id): void
    {
        $this->swapOrder($id, '<', 'desc');
    }

    public function moveDown(int $id): void
    {
        $this->swapOrder($id, '>', 'asc');
    }

    protected function swapOrder(int $id, string $op, string $dir): void
    {
        $record = $this->model()::findOrFail($id);
        $other = $this->model()::where('sort_order', $op, $record->sort_order)->orderBy('sort_order', $dir)->first();
        if ($other) {
            [$a, $b] = [$record->sort_order, $other->sort_order];
            $record->update(['sort_order' => $b]);
            $other->update(['sort_order' => $a]);
        }
    }

    protected function resetForm(): void
    {
        $this->reset(['form', 'uploads', 'editingId']);
        $this->resetValidation();
    }

    protected function buildRules(): array
    {
        $rules = [];
        foreach ($this->fields() as $name => $field) {
            $type = $field['type'] ?? 'text';
            $required = $field['required'] ?? false;
            if ($type === 'image') {
                $hasExisting = $this->editingId && $this->model()::whereKey($this->editingId)->whereNotNull($name)->exists();
                $rules["uploads.$name"] = [($required && ! $hasExisting) ? 'required' : 'nullable', 'image', 'max:'.($field['max'] ?? 4096)];
            } elseif ($type === 'file') {
                $hasExisting = $this->editingId && $this->model()::whereKey($this->editingId)->whereNotNull($name)->exists();
                $rules["uploads.$name"] = [($required && ! $hasExisting) ? 'required' : 'nullable', 'file', 'max:'.($field['max'] ?? 20480), 'mimes:'.($field['mimes'] ?? 'pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png')];
            } else {
                $base = match ($type) {
                    'url' => ['url:http,https', 'max:500'],
                    'email' => ['email', 'max:150'],
                    'number' => ['integer', 'min:0', 'max:999999'],
                    'toggle' => ['boolean'],
                    'date', 'datetime' => ['date'],
                    'select' => ['in:'.implode(',', array_keys($field['options'] ?? []))],
                    'textarea', 'richtext' => ['string', 'max:200000'],
                    'password' => ['string', 'min:8'],
                    default => ['string', 'max:255'],
                };
                $rules["form.$name"] = array_merge([$required && ! ($type === 'password' && $this->editingId) ? 'required' : 'nullable'], $base, $field['rules'] ?? []);
            }
        }

        return $rules;
    }

    protected function attributeNames(): array
    {
        return collect($this->fields())->flatMap(fn ($f, $name) => [
            "form.$name" => strtolower($f['label']),
            "uploads.$name" => strtolower($f['label']),
        ])->all();
    }

    public function render()
    {
        $records = $this->query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    foreach ($this->searchable as $col) {
                        $q->orWhere($col, 'like', "%{$this->search}%");
                    }
                });
            })
            ->orderBy($this->orderBy, $this->orderDirection)
            ->orderByDesc('id')
            ->paginate($this->perPage);

        $current = $this->editingId ? $this->model()::find($this->editingId) : null;

        return view('livewire.admin.resource', [
            'records' => $records,
            'columns' => $this->columns(),
            'fields' => $this->fields(),
            'current' => $current,
            'sortable' => $this->orderBy === 'sort_order',
        ])->title($this->title);
    }
}
