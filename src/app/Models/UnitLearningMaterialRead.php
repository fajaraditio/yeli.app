<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class UnitLearningMaterialRead extends Model
{
    #[Override]
    public function getCasts(): array
    {
        return  [
            'read_at' => 'datetime',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(UnitLearningMaterial::class, 'unit_learning_material_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
