<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        @php
            use App\Models\Setting;

            $settings = Setting::whereIn('key', [
                'company.name',
                'company.logo',
            ])->pluck('value', 'key');

            $companyName = $settings['company.name'] ?? config('app.name');
            $companyLogo = $settings['company.logo'] ?? null;
        @endphp
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                @if ($companyLogo)
                    <img src="{{ asset($companyLogo) }}" alt="{{ $companyName }}" class="h-8 w-auto rounded-lg object-contain" />
                @else
                    <x-app-logo />
                @endif
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Company Profile')" class="grid">
                    <flux:navlist.item icon="sparkles" :href="route('admin.hero')" :current="request()->routeIs('admin.hero')" wire:navigate>{{ __('Hero Section') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('admin.about')" :current="request()->routeIs('admin.about')" wire:navigate>{{ __('About Section') }}</flux:navlist.item>
                    <flux:navlist.item icon="star" :href="route('admin.highlights')" :current="request()->routeIs('admin.highlights')" wire:navigate>{{ __('Highlights') }}</flux:navlist.item>
                    <flux:navlist.item icon="briefcase" :href="route('admin.services')" :current="request()->routeIs('admin.services')" wire:navigate>{{ __('Services') }}</flux:navlist.item>
                    <flux:navlist.item icon="cube" :href="route('admin.products')" :current="request()->routeIs('admin.products')" wire:navigate>{{ __('Products') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('admin.partners')" :current="request()->routeIs('admin.partners')" wire:navigate>{{ __('Partners') }}</flux:navlist.item>
                    <flux:navlist.item icon="question-mark-circle" :href="route('admin.faqs')" :current="request()->routeIs('admin.faqs')" wire:navigate>{{ __('FAQs') }}</flux:navlist.item>
                    <flux:navlist.item icon="photo" :href="route('admin.gallery')" :current="request()->routeIs('admin.gallery')" wire:navigate>{{ __('Gallery') }}</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-bottom-center-text" :href="route('admin.testimonials')" :current="request()->routeIs('admin.testimonials')" wire:navigate>{{ __('Testimonials') }}</flux:navlist.item>
                    <flux:navlist.item icon="cog-6-tooth" :href="route('admin.settings')" :current="request()->routeIs('admin.settings')" wire:navigate>{{ __('Kontak & Sosial') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
