<?php

namespace App\Filament;

use Filament\AvatarProviders\Contracts;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DiceBearAvatarsProvider implements Contracts\AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        return 'https://api.dicebear.com/10.x/thumbs/svg?seed=' . $record->id;
    }
}
