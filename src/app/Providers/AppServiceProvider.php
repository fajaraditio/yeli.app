<?php

namespace App\Providers;

use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
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
    }
}
