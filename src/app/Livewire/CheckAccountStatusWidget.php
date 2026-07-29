<?php

namespace App\Livewire;

use App\Constants\UserConstant;
use Filament\Widgets\Widget;

class CheckAccountStatusWidget extends Widget
{
    protected string $view = 'livewire.check-account-status-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -10;

    public static function canView(): bool
    {
        return auth()->user()?->status === UserConstant::Status_Pending;
    }
}
