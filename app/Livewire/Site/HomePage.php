<?php

namespace App\Livewire\Site;

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
use Illuminate\Support\Arr;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class HomePage extends Component
{
    public function render()
    {
        $hero = HeroSection::first();
        $about = AboutSection::first();
        $highlights = Highlight::query()->latest()->limit(4)->get();
        $services = Service::all();
        $products = Product::query()->latest()->limit(6)->get();
        $testimonials = Testimonial::query()->latest()->limit(6)->get();
        $gallery = GalleryItem::query()->latest()->limit(6)->get();
        $partners = Partner::query()->latest()->limit(8)->get();
        $faqs = Faq::query()->limit(6)->get();

        $settings = Setting::whereIn('key', [
            'company.phone',
            'company.email',
            'company.address',
            'company.office_hours',
            'company.logo',
            'company.socials',
            'company.name',
        ])->pluck('value', 'key');

        $socials = json_decode($settings['company.socials'] ?? '[]', true) ?? [];

        $companyProfile = [
            'company_name' => $settings['company.name'] ?? config('app.name'),
            'office_address' => $settings['company.address'] ?? null,
            'contact_email' => $settings['company.email'] ?? null,
            'contact_phone' => $settings['company.phone'] ?? null,
            'office_hours' => $settings['company.office_hours'] ?? null,
            'logo' => $settings['company.logo'] ?? null,
            'social_links' => $socials,
        ];

        $contact = [
            'phone' => $companyProfile['contact_phone'],
            'email' => $companyProfile['contact_email'],
            'address' => $companyProfile['office_address'],
            'office_hours' => $companyProfile['office_hours'],
            'logo' => $companyProfile['logo'],
            'socials' => [
                'instagram' => Arr::get($socials, 'instagram'),
                'linkedin' => Arr::get($socials, 'linkedin'),
                'youtube' => Arr::get($socials, 'youtube'),
            ],
        ];

        return view('livewire.site.home-page', [
            'hero' => $hero,
            'about' => $about,
            'highlights' => $highlights,
            'services' => $services,
            'products' => $products,
            'testimonials' => $testimonials,
            'gallery' => $gallery,
            'partners' => $partners,
            'faqs' => $faqs,
            'contact' => $contact,
            'companyProfile' => $companyProfile,
        ])->layoutData([
            'siteName' => $companyProfile['company_name'],
            'companyName' => $companyProfile['company_name'],
            'logoUrl' => $contact['logo'] ?? asset('images/logo.png'),
            'navigation' => [
                ['label' => 'Beranda', 'href' => '#hero'],
                ['label' => 'Tentang', 'href' => '#about'],
                ['label' => 'Layanan', 'href' => '#services'],
                ['label' => 'Produk', 'href' => '#products'],
                ['label' => 'Keunggulan', 'href' => '#advantages'],
                ['label' => 'Testimoni', 'href' => '#testimonials'],
                ['label' => 'Galeri', 'href' => '#gallery'],
                ['label' => 'Partner', 'href' => '#partners'],
                ['label' => 'Lokasi', 'href' => '#location'],
                ['label' => 'FAQ', 'href' => '#faq'],
            ],
            'settings' => $settings,
        ]);
    }
}
