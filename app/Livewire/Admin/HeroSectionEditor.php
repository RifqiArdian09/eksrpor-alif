<?php

namespace App\Livewire\Admin;

use App\Models\HeroSection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Kelola Hero Section'])]
class HeroSectionEditor extends Component
{
    use WithFileUploads;

    public ?int $heroId = null;

    #[Validate('nullable|string')]
    public ?string $tagline = null;

    #[Validate('required|string')]
    public string $title = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public ?string $mediaPath = null;

    #[Validate('nullable|file|max:5120')]
    public $mediaUpload = null;

    public function mount(): void
    {
        $hero = HeroSection::first();

        if ($hero) {
            $this->heroId = $hero->id;
            $this->tagline = $hero->tagline;
            $this->title = (string) $hero->title;
            $this->description = $hero->description;
            $this->mediaPath = $hero->media_path;
        }
    }

    public function save(): void
    {
        $validated = $this->validate();

        $mediaPath = $this->mediaPath;

        if ($this->mediaUpload) {
            $stored = $this->mediaUpload->store('hero', 'public');
            $mediaPath = 'storage/' . ltrim($stored, '/');
        }

        $record = HeroSection::updateOrCreate(
            ['id' => $this->heroId],
            [
                'tagline' => $validated['tagline'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'media_path' => $mediaPath,
            ]
        );

        $this->heroId = $record->id;

        $this->dispatch('saved', message: __('Hero section updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.hero-section-editor');
    }
}
