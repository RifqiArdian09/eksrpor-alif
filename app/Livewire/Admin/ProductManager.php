<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Kelola Produk'])]
class ProductManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage = 9;

    public ?int $editingId = null;

    #[Validate('required|string|max:150')]
    public string $title = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public ?string $thumbnailPath = null;

    #[Validate('nullable|image|max:2048')]
    public $thumbnailUpload = null;

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description', 'thumbnailPath', 'thumbnailUpload']);
        $this->resetErrorBag();
    }

    public function edit(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $this->editingId = $product->id;
        $this->title = $product->title;
        $this->description = $product->description;
        $this->thumbnailPath = $product->thumbnail_path;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $thumbnailPath = $this->thumbnailPath;

        if ($this->thumbnailUpload) {
            $stored = $this->thumbnailUpload->store('products', 'public');
            $thumbnailPath = 'storage/' . ltrim($stored, '/');
        }

        Product::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'thumbnail_path' => $thumbnailPath,
            ]
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Product saved.'));
    }

    public function delete(int $productId): void
    {
        Product::findOrFail($productId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Product deleted.'));
    }

    public function render()
    {
        return view('livewire.admin.product-manager', [
            'products' => Product::query()->latest()->paginate($this->perPage),
        ]);
    }
}
