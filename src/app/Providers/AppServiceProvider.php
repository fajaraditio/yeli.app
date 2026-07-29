<?php

namespace App\Providers;

use App\Filament\Administrator\Pages\Login as AdministratorLogin;
use App\Filament\Lecturer\Pages\Login as LecturerLogin;
use App\Filament\Student\Pages\Login as StudentLogin;
use App\Filament\Lecturer\Pages\Register as LecturerRegister;
use App\Filament\Student\Pages\Register as StudentRegister;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Model::unguard();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        CreateAction::configureUsing(function (Action $action) {
            $action
                ->icon(Phosphor::Plus);
        });

        EditAction::configureUsing(function (Action $action) {
            $action
                ->color('success')
                ->icon(Phosphor::Pencil);
        });

        ViewAction::configureUsing(function (Action $action) {
            $action
                ->color('secondary');
        });

        DeleteAction::configureUsing(function (Action $action) {
            $action
                ->color('danger')
                ->icon(Phosphor::Trash);
        });

        Table::configureUsing(function (Table $table) {
            $table->defaultSort('id', 'desc');
        });

        FilamentView::registerRenderHook(
            PanelsRenderHook::SIMPLE_PAGE_START,
            fn(): View => view('livewire.hooks.back-to-portal'),
            scopes: [
                AdministratorLogin::class,
                LecturerLogin::class,
                LecturerRegister::class,
                StudentLogin::class,
                StudentRegister::class,
            ]
        );
    }
}
