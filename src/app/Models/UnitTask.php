<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class UnitTask extends Model
{
    #[Override]
    public function getCasts(): array
    {
        return [
            'input_schema' => 'array',
        ];
    }

    public function unitStage(): BelongsTo
    {
        return $this->belongsTo(UnitStage::class);
    }
}
