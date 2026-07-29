<?php

namespace App\Filament\Student\Pages;

use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Phosphor::House;
}
