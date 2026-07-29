<?php

namespace App\Providers\Filament;

use App\Filament\Administrator\Pages\Login;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdministratorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('administrator')
            ->login(Login::class)
            ->brandLogo(asset('/images/logo-yeli.png'))
            ->brandLogoHeight('100px')
            ->font('Google Sans', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => [
                    50  => '#CAD1E3',
                    100 => '#C2CADE',
                    200 => '#AEB8D3',
                    300 => '#91A1C8',
                    400 => '#7085B8',
                    500 => '#5168A2',
                    600 => '#425585',
                    700 => '#35446A',
                    800 => '#253252',
                    900 => '#1A233A',
                    950 => '#0F1422',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Administrator/Resources'), for: 'App\Filament\Administrator\Resources')
            ->discoverPages(in: app_path('Filament/Administrator/Pages'), for: 'App\Filament\Administrator\Pages')
            ->discoverWidgets(in: app_path('Filament/Administrator/Widgets'), for: 'App\Filament\Administrator\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
