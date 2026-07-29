<?php

namespace App\Filament\Lecturer\Pages;

use App\Livewire\CheckAccountStatusWidget;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Pages\Dashboard as BaseDashboard;
use Override;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Phosphor::House;

    #[Override]
    public function getColumns(): int | array
    {
        return 1;
    }

    #[Override]
    public function getWidgets(): array
    {
        return [
            CheckAccountStatusWidget::class,
        ];
    }
}
