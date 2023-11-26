<?php

namespace App\Providers\Filament;

use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use EightyNine\Approvals\ApprovalPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Shipu\WebInstaller\Middleware\RedirectIfNotInstalled;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false,
                        // Adds a main navigation item for the My Profile page (default = false)
                        hasAvatars: false, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->enableTwoFactorAuthentication()
                    ->enableSanctumTokens(),
                SpotlightPlugin::make(),
                ApprovalPlugin::make(),
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
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
                    ->navigationGroup('Master')
                    ->navigationSort(3)
                    ->navigationCountBadge()
            ])
            ->databaseNotifications()
//            ->databaseNotificationsPolling('30s')
            ->favicon(asset('favicon-white.png'))
            ->brandName(config('custom.app.name'))
            ->brandLogo(asset('images/logo/svg/logo-rumahdata-no-background.svg'))
            ->brandLogoHeight(config('custom.app.logo_height'))
            ->darkModeBrandLogo(asset('images/logo/logo-white.png'))
            ->darkMode(config('custom.app.dark_mode', true))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->font(config('custom.app.font', 'Inter'))
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('master')
                    ->label('Master')
                    ->collapsible()
                    ->collapsed(),
                NavigationGroup::make('bantuan')
                    ->label('Bantuan')
                    ->collapsible()
                    ->collapsed(),
                NavigationGroup::make('pengaturan')
                    ->label('Pengaturan')
                    ->collapsible()
                    ->collapsed(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                AccountWidget::class,
//                FilamentInfoWidget::class,
//                KeluargaChart::class
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
                RedirectIfNotInstalled::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
