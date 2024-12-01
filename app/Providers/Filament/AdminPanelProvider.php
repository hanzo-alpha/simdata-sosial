<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Settings\Settings;
use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\Platform;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Kenepa\Banner\BannerPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;
use Outerweb\FilamentSettings\Filament\Plugins\FilamentSettingsPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->default()
            ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->path('dashboard')
            ->databaseTransactions()
            ->login(CustomLogin::class)
            ->passwordReset()
            ->maxContentWidth(MaxWidth::Full)
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Sky,
                'primary' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
                'secondary' => Color::Indigo,
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        slug: 'profil',
                    )
                    ->enableTwoFactorAuthentication(),
                SpotlightPlugin::make(),
                FilamentShieldPlugin::make(),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Dashboard Bantuan')
                    ->navigationSort(3)
                    ->defaultListView('grid'),
                FilamentJobsMonitorPlugin::make(),
                FilamentApexChartsPlugin::make(),
                FilamentSettingsPlugin::make()
                    ->pages([
                        Settings::class,
                    ]),
                FilamentProgressbarPlugin::make(),
                BannerPlugin::make()
                    ->persistsBannersInDatabase()
                    ->title('Pengaturan Pengumuman')
                    ->subheading('Atur Pengumuman anda')
                    ->navigationGroup('Pengaturan')
                    ->navigationLabel('Pengumuman')
                    ->bannerManagerAccessPermission('page_BannerManagerPage'),
                //                GlobalSearchModalPlugin::make(),
            ])
            ->databaseNotifications()
            ->favicon(asset('images/reno/reno-dinsos-favicon-white.png'))
            ->brandName(config('custom.app.name'))
            ->brandLogo(asset('images/reno/svg/logo-no-background.svg'))
            ->brandLogoHeight(config('custom.app.logo_height'))
            ->darkModeBrandLogo(asset('images/reno/reno-dinsos-high-resolution-logo-white-transparent.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->font(config('custom.app.font', 'Inter'))
            ->pages([
                Dashboard::class,
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
            ], isPersistent: true)
//            ->globalSearchKeyBindings(['ctrl+alt+s'])
//            ->globalSearchFieldKeyBindingSuffix()
            ->globalSearchFieldSuffix(fn(): ?string => match (Platform::detect()) {
                Platform::Windows => 'CTRL+ALT+S',
                Platform::Linux,
                Platform::Mac => '⌘K',
                default => null,
            })
            ->authMiddleware([
                Authenticate::class,
            ], isPersistent: true)
            ->renderHook('panels::head.end', fn(): View => view('livewire-head'))
            ->renderHook('panels::body.end', fn(): View => view('livewire-body'))
            ->resources([
                config('filament-logger.activity_resource'),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
