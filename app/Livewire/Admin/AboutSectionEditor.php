<?php

namespace App\Livewire\Admin;

use App\Models\AboutSection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Kelola About Section'])]
class AboutSectionEditor extends Component
{
    use WithFileUploads;

    public ?int $aboutId = null;

    #[Validate('nullable|string')]
    public ?string $vision = null;

    #[Validate('nullable|string')]
    public ?string $mission = null;

    #[Validate('nullable|string')]
    public ?string $content = null;

    public ?string $imagePath = null;

    #[Validate('nullable|image|max:3072')]
    public $imageUpload = null;

    public string $previewMode = 'markdown';

    public function mount(): void
    {
        $about = AboutSection::first();

        if ($about) {
            $this->aboutId = $about->id;
            $this->vision = $about->vision;
            $this->mission = $about->mission;
            $this->content = $about->content;
            $this->imagePath = $about->image_path;
        }
    }

    public function togglePreview(string $mode): void
    {
        $this->previewMode = $mode;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $imagePath = $this->imagePath;

        if ($this->imageUpload) {
            $stored = $this->imageUpload->store('about', 'public');
            $imagePath = 'storage/' . ltrim($stored, '/');
        }

        $payload = [
            'vision' => $this->vision,
            'mission' => $this->mission,
            'content' => $this->content,
            'image_path' => $imagePath,
        ];

        $record = AboutSection::updateOrCreate(
            ['id' => $this->aboutId],
            $payload
        );

        $this->aboutId = $record->id;

        $this->dispatch('saved', message: __('About section updated successfully.'));
    }

    public function markdownSnippet(string $type): void
    {
        $snippet = match ($type) {
            'values' => "### Nilai Perusahaan\n\n- Fokus pada kualitas\n- Transparansi dan integritas\n- Kemitraan jangka panjang", // NOSONAR
            'cta' => "> Ayo jadwalkan konsultasi dan jelajahi pasar global bersama kami.",
            default => ''
        };

        if ($snippet) {
            $this->content = Str::of($this->content)->append('\n\n' . $snippet)->trim()->toString();
        }
    }

    public function render()
    {
        return view('livewire.admin.about-section-editor');
    }
}
