<?php

namespace App\Livewire\Admin;

use App\Models\Partner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kelola Partner'])]
class PartnerManager extends Component
{
    use WithPagination;

    use \Livewire\WithFileUploads;

    public int $perPage = 12;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $name = '';

    public ?string $logoPath = null;

    #[Validate('nullable|image|max:3072')]
    public $logoUpload = null;

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'logoPath', 'logoUpload']);
        $this->resetErrorBag();
    }

    public function edit(int $partnerId): void
    {
        $partner = Partner::findOrFail($partnerId);

        $this->editingId = $partner->id;
        $this->name = $partner->name;
        $this->logoPath = $partner->logo_path;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $logoPath = $this->logoPath;

        if ($this->logoUpload) {
            $stored = $this->logoUpload->store('partners', 'public');
            $logoPath = 'storage/' . ltrim($stored, '/');
        }

        Partner::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $validated['name'],
                'logo_path' => $logoPath,
            ]
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Partner saved.'));
    }

    public function delete(int $partnerId): void
    {
        Partner::findOrFail($partnerId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Partner deleted.'));
    }

    public function render()
    {
        return view('livewire.admin.partner-manager', [
            'partners' => Partner::query()->latest()->paginate($this->perPage),
        ]);
    }
}
