<?php

namespace App\Livewire\Admin;

use App\Models\Highlight;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kelola Highlight'])]
class HighlightManager extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $title = '';

    #[Validate('nullable|string|max:500')]
    public ?string $description = null;

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description']);
        $this->resetErrorBag();
    }

    public function edit(int $highlightId): void
    {
        $highlight = Highlight::findOrFail($highlightId);

        $this->editingId = $highlight->id;
        $this->title = $highlight->title;
        $this->description = $highlight->description;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Highlight::updateOrCreate(
            ['id' => $this->editingId],
            $validated
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Highlight saved.'));
    }

    public function delete(int $highlightId): void
    {
        Highlight::findOrFail($highlightId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Highlight deleted.'));
    }

    public function render()
    {
        return view('livewire.admin.highlight-manager', [
            'highlights' => Highlight::query()->latest()->paginate($this->perPage),
        ]);
    }
}
