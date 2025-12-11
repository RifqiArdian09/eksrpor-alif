<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kelola Services'])]
class ServiceManager extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $title = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description']);
        $this->resetErrorBag();
    }

    public function edit(int $serviceId): void
    {
        $service = Service::findOrFail($serviceId);

        $this->editingId = $service->id;
        $this->title = $service->title;
        $this->description = $service->description;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Service::updateOrCreate(
            ['id' => $this->editingId],
            $validated
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Service saved.'));
    }

    public function delete(int $serviceId): void
    {
        Service::findOrFail($serviceId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Service deleted.'));
    }

    public function render()
    {
        return view('livewire.admin.service-manager', [
            'services' => Service::query()->latest()->paginate($this->perPage),
        ]);
    }
}
