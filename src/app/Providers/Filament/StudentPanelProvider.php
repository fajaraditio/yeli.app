<?php

namespace App\Providers\Filament;

use App\Filament\Student\Pages\Dashboard;
use App\Filament\Student\Pages\Login;
use App\Filament\Student\Pages\Register;
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

class StudentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('student')
            ->path('student')
            ->login(Login::class)
            ->registration(Register::class)
            ->brandName('YELI App')
            ->brandLogo(fn() => view('filament.brand.logo', ['panel' => $panel]))
            ->brandLogoHeight('80px')
            ->maxContentWidth(Width::Full)
            ->font('Google Sans', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => [
                    50  => '#FAEFD7',
                    100 => '#F9EACA',
                    200 => '#F5DFAC',
                    300 => '#F7D280',
                    400 => '#F4C04E',
                    500 => '#F0AD18',
                    600 => '#CB900D',
                    700 => '#A2730B',
                    800 => '#7E5803',
                    900 => '#593E02',
                    950 => '#342401',
                ],
            ])
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Student/Resources'), for: 'App\Filament\Student\Resources')
            ->discoverPages(in: app_path('Filament/Student/Pages'), for: 'App\Filament\Student\Pages')
            ->discoverWidgets(in: app_path('Filament/Student/Widgets'), for: 'App\Filament\Student\Widgets')
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
            ->defaultAvatarProvider(DiceBearAvatarsProvider::class)
            ->viteTheme('resources/css/filament/student/theme.css');
    }
}
