<?php

namespace App\Providers\Filament;

use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->topNavigation()
//            ->sidebarCollapsibleOnDesktop()
            ->id('admin')
            ->path('dashboard')
            ->spa()
            ->login()
            ->profile()
            ->passwordReset()
            ->maxContentWidth(MaxWidth::Full)
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
                'secondary' => Color::Indigo,
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false,
                        // Adds a main navigation item for the My Profile page (default = false)
                        hasAvatars: false, // Enables the avatar upload form component (default = false)
                        slug: 'profil-saya' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->enableTwoFactorAuthentication()
                    ->enableSanctumTokens(),
                SpotlightPlugin::make(),
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Dashboard Bantuan')
                    ->navigationSort(3)
                    ->navigationCountBadge(),
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->favicon(asset('images/logos/favicon-white.png'))
            ->brandName(config('custom.app.name'))
            ->brandLogo(asset('images/logos/svg/logo-no-background.svg'))
            ->brandLogoHeight(config('custom.app.logo_height'))
            ->darkModeBrandLogo(asset('images/logos/logo-white.png'))
            ->darkMode(config('custom.app.dark_mode', true))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->font(config('custom.app.font', 'Inter'))
            ->pages([
                //                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('program sosial')
                    ->label('Program Sosial')
                    ->collapsible()
                    ->collapsed(),
                NavigationGroup::make('dashboard bantuan')
                    ->label('Dashboard Bantuan')
                    ->collapsible()
                    ->collapsed(),
                NavigationGroup::make('pengaturan')
                    ->label('Pengaturan')
                    ->collapsible()
                    ->collapsed(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //                PenerimaManfaatChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook('panels::head.end', fn (): View => view('livewire-head'))
            ->renderHook('panels::body.end', fn (): View => view('livewire-body'))
            ->resources([
                config('filament-logger.activity_resource'),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
