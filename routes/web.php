<?php

use App\Livewire\Admin\AboutSectionEditor;
use App\Livewire\Admin\CompanyOverview;
use App\Livewire\Admin\FaqManager;
use App\Livewire\Admin\GalleryManager;
use App\Livewire\Admin\HeroSectionEditor;
use App\Livewire\Admin\HighlightManager;
use App\Livewire\Admin\PartnerManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\ServiceManager;
use App\Livewire\Admin\SettingsManager;
use App\Livewire\Admin\TestimonialManager;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Site\GalleryIndex;
use App\Livewire\Site\GalleryShow;
use App\Livewire\Site\HomePage;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', HomePage::class)->name('home');
Route::get('/gallery', GalleryIndex::class)->name('gallery.index');
Route::get('/gallery/{galleryItem}', GalleryShow::class)->name('gallery.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', CompanyOverview::class)->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('about', AboutSectionEditor::class)->name('about');
        Route::get('hero', HeroSectionEditor::class)->name('hero');
        Route::get('highlights', HighlightManager::class)->name('highlights');
        Route::get('services', ServiceManager::class)->name('services');
        Route::get('products', ProductManager::class)->name('products');
        Route::get('partners', PartnerManager::class)->name('partners');
        Route::get('faqs', FaqManager::class)->name('faqs');
        Route::get('gallery', GalleryManager::class)->name('gallery');
        Route::get('testimonials', TestimonialManager::class)->name('testimonials');
        Route::get('settings', SettingsManager::class)->name('settings');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
