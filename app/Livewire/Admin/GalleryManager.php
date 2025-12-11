<?php

namespace App\Livewire\Admin;

use App\Models\GalleryItem;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Kelola Galeri'])]
class GalleryManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage = 8;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $title = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('nullable|date')]
    public ?string $activityDate = null;

    public ?string $imagePath = null;

    #[Validate('nullable|image|max:4096')]
    public $coverUpload = null;

    #[Validate('required|string|max:150')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $imagesInput = null;

    #[Validate('nullable|array')]
    public array $imagesUploads = [];

    public ?int $confirmingDeletionId = null;

    public function updatedTitle(): void
    {
        if (! $this->editingId && blank($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description', 'activityDate', 'imagePath', 'slug', 'imagesInput', 'coverUpload', 'imagesUploads']);
        $this->resetErrorBag();
    }

    public function edit(int $itemId): void
    {
        $item = GalleryItem::findOrFail($itemId);

        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->description = $item->description;
        $this->activityDate = optional($item->activity_date)->format('Y-m-d');
        $this->imagePath = $item->image_path;
        $this->slug = $item->slug;
        $this->imagesInput = collect($item->images ?? [])->implode(', ');
    }

    public function save(): void
    {
        $validated = $this->validate();

        $coverPath = $this->imagePath;

        if ($this->coverUpload) {
            $stored = $this->coverUpload->store('gallery', 'public');
            $coverPath = 'storage/' . ltrim($stored, '/');
        }

        $additionalImages = collect(explode(',', (string) ($validated['imagesInput'] ?? '')))
            ->map(fn ($path) => trim($path))
            ->filter()
            ->values()
            ->toArray();

        foreach ($this->imagesUploads as $upload) {
            $stored = $upload->store('gallery', 'public');
            $additionalImages[] = 'storage/' . ltrim($stored, '/');
        }

        GalleryItem::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'activity_date' => $validated['activityDate'] ?? null,
                'image_path' => $coverPath,
                'slug' => $validated['slug'],
                'images' => $additionalImages,
            ]
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Galeri disimpan.'));
    }

    public function delete(int $itemId): void
    {
        GalleryItem::findOrFail($itemId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Galeri dihapus.'));
    }

    public function render()
    {
        return view('livewire.admin.gallery-manager', [
            'items' => GalleryItem::query()->latest()->paginate($this->perPage),
        ]);
    }
}
