<?php

namespace App\Livewire\Site;

use App\Models\GalleryItem;
use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
class GalleryIndex extends Component
{
    use WithPagination;

    public int $perPage = 9;

    public function render()
    {
        $settings = $this->settings();

        return view('livewire.site.gallery-index', [
            'items' => GalleryItem::query()->latest()->paginate($this->perPage),
        ])->layoutData($this->layoutData($settings));
    }

    protected function settings()
    {
        return Setting::whereIn('key', [
            'company.phone',
            'company.email',
            'company.address',
            'company.logo',
            'company.name',
        ])->pluck('value', 'key');
    }

    protected function layoutData($settings): array
    {
        return [
            'siteName' => $settings['company.name'] ?? config('app.name'),
            'companyName' => $settings['company.name'] ?? config('app.name'),
            'logoUrl' => $this->resolveLogoUrl($settings),
            'settings' => $settings,
        ];
    }

    protected function resolveLogoUrl($settings): string
    {
        $logo = $settings['company.logo'] ?? null;

        if ($logo) {
            if (Str::startsWith($logo, ['http://', 'https://', '//', '/', 'data:'])) {
                return $logo;
            }

            return asset($logo);
        }

        return asset('images/logo.png');
    }
}
