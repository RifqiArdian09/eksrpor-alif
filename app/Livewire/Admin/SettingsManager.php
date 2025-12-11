<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app', ['title' => 'Kontak & Sosial'])]
class SettingsManager extends Component
{
    use WithFileUploads;

    #[Validate('nullable|string|max:150')]
    public ?string $companyName = null;

    #[Validate('nullable|string|max:50')]
    public ?string $phone = null;

    #[Validate('nullable|email|max:150')]
    public ?string $email = null;

    #[Validate('nullable|string|max:255')]
    public ?string $address = null;

    #[Validate('nullable|string|max:150')]
    public ?string $officeHours = null;

    #[Validate('nullable|url|max:255')]
    public ?string $instagram = null;

    #[Validate('nullable|url|max:255')]
    public ?string $linkedin = null;

    #[Validate('nullable|url|max:255')]
    public ?string $youtube = null;

    #[Validate('nullable|string|max:255')]
    public ?string $logo = null;

    #[Validate('nullable|image|max:3072')]
    public $logoUpload = null;

    public function mount(): void
    {
        $settings = Setting::whereIn('key', [
            'company.name',
            'company.phone',
            'company.email',
            'company.address',
            'company.office_hours',
            'company.logo',
            'company.socials',
        ])->pluck('value', 'key');

        $this->companyName = $settings['company.name'] ?? null;
        $this->phone = $settings['company.phone'] ?? null;
        $this->email = $settings['company.email'] ?? null;
        $this->address = $settings['company.address'] ?? null;
        $this->officeHours = $settings['company.office_hours'] ?? null;

        $this->logo = $settings['company.logo'] ?? null;

        $socials = $settings['company.socials'] ?? [];
        $this->instagram = $socials['instagram'] ?? null;
        $this->linkedin = $socials['linkedin'] ?? null;
        $this->youtube = $socials['youtube'] ?? null;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->logoUpload) {
            $stored = $this->logoUpload->store('company', 'public');
            $this->logo = 'storage/' . ltrim($stored, '/');
            $this->logoUpload = null;
        }

        $this->upsert('company.name', $this->companyName, 'text');
        $this->upsert('company.phone', $this->phone, 'text');
        $this->upsert('company.email', $this->email, 'text');
        $this->upsert('company.address', $this->address, 'text');
        $this->upsert('company.office_hours', $this->officeHours, 'text');
        $this->upsert('company.logo', $this->logo, 'text');

        $socials = array_filter([
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
        ]);

        $this->upsert('company.socials', $socials ?: null, 'json');

        $this->dispatch('toast', message: __('Pengaturan kontak berhasil diperbarui.'));
    }

    protected function upsert(string $key, mixed $value, string $type): void
    {
        if (is_null($value) || $value === '') {
            Setting::where('key', $key)->delete();

            return;
        }

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
