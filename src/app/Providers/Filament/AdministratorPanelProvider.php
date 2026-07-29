<?php

namespace App\Providers\Filament;

use App\Filament\Administrator\Pages\Dashboard;
use App\Filament\Administrator\Pages\Login;
use App\Providers\Filament\Avatars\DiceBearAvatarsProvider;
use Filafly\Icons\Phosphor\PhosphorIcons;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Enums\Width;
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
            ->brandName('YELI App')
            ->brandLogo(fn() => view('filament.brand.logo', ['panel' => $panel]))
            ->brandLogoHeight('80px')
            ->maxContentWidth(Width::Full)
            ->font('Google Sans', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => [
                    50  => '#798CBC',
                    100 => '#7487B8',
                    200 => '#657AB0',
                    300 => '#4F6AA9',
                    400 => '#445A91',
                    500 => '#384A77',
                    600 => '#2E3C62',
                    700 => '#25304E',
                    800 => '#19233C',
                    900 => '#12192B',
                    950 => '#0A0E19',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Administrator/Resources'), for: 'App\Filament\Administrator\Resources')
            ->discoverPages(in: app_path('Filament/Administrator/Pages'), for: 'App\Filament\Administrator\Pages')
            ->discoverWidgets(in: app_path('Filament/Administrator/Widgets'), for: 'App\Filament\Administrator\Widgets')
            ->topNavigation()
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                //
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
            ->plugins([
                PhosphorIcons::make(),
            ])
            ->databaseNotifications()
            ->defaultAvatarProvider(DiceBearAvatarsProvider::class)
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
