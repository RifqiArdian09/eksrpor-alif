<?php

namespace App\Livewire\Admin;

use App\Models\AboutSection;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HeroSection;
use App\Models\Highlight;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Dashboard'])]
class CompanyOverview extends Component
{
    public function render()
    {
        return view('livewire.admin.company-overview', [
            'stats' => [
                [
                    'label' => __('Total Highlights'),
                    'count' => Highlight::count(),
                    'icon' => 'sparkles',
                ],
                [
                    'label' => __('Services'),
                    'count' => Service::count(),
                    'icon' => 'briefcase',
                ],
                [
                    'label' => __('Products'),
                    'count' => Product::count(),
                    'icon' => 'cube',
                ],
                [
                    'label' => __('Partners'),
                    'count' => Partner::count(),
                    'icon' => 'users',
                ],
                [
                    'label' => __('FAQs'),
                    'count' => Faq::count(),
                    'icon' => 'question-mark-circle',
                ],
                [
                    'label' => __('Gallery Items'),
                    'count' => GalleryItem::count(),
                    'icon' => 'photo',
                ],
                [
                    'label' => __('Testimonials'),
                    'count' => Testimonial::count(),
                    'icon' => 'chat-bubble-bottom-center-text',
                ],
            ],
            'heroUpdatedAt' => HeroSection::query()->latest('updated_at')->value('updated_at'),
            'aboutUpdatedAt' => AboutSection::query()->latest('updated_at')->value('updated_at'),
            'contactSettings' => Setting::whereIn('key', [
                'company.phone',
                'company.email',
                'company.address',
            ])->pluck('value', 'key'),
            'recentActivity' => collect([
                Highlight::query()->latest('updated_at')->first(),
                Service::query()->latest('updated_at')->first(),
                Product::query()->latest('updated_at')->first(),
                Partner::query()->latest('updated_at')->first(),
                Faq::query()->latest('updated_at')->first(),
                GalleryItem::query()->latest('updated_at')->first(),
                Testimonial::query()->latest('updated_at')->first(),
            ])->filter(),
        ]);
    }
}
