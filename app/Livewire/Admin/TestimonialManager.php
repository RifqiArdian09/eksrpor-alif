<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kelola Testimoni'])]
class TestimonialManager extends Component
{
    use WithPagination;

    use \Livewire\WithFileUploads;

    public int $perPage = 8;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $name = '';

    #[Validate('nullable|string|max:150')]
    public ?string $exportedItem = null;

    #[Validate('required|string')]
    public string $body = '';

    public ?string $photoPath = null;

    #[Validate('nullable|image|max:3072')]
    public $photoUpload = null;

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'exportedItem', 'body', 'photoPath', 'photoUpload']);
        $this->resetErrorBag();
    }

    public function edit(int $testimonialId): void
    {
        $testimonial = Testimonial::findOrFail($testimonialId);

        $this->editingId = $testimonial->id;
        $this->name = $testimonial->name;
        $this->exportedItem = $testimonial->exported_item;
        $this->body = $testimonial->body;
        $this->photoPath = $testimonial->photo_path;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $photoPath = $this->photoPath;

        if ($this->photoUpload) {
            $stored = $this->photoUpload->store('testimonials', 'public');
            $photoPath = 'storage/' . ltrim($stored, '/');
        }

        Testimonial::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $validated['name'],
                'exported_item' => $validated['exportedItem'] ?? null,
                'body' => $validated['body'],
                'photo_path' => $photoPath,
            ]
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Testimoni disimpan.'));
    }

    public function delete(int $testimonialId): void
    {
        Testimonial::findOrFail($testimonialId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Testimoni dihapus.'));
    }

    public function render()
    {
        return view('livewire.admin.testimonial-manager', [
            'testimonials' => Testimonial::query()->latest()->paginate($this->perPage),
        ]);
    }
}
