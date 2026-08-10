<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class UnitStage extends Model
{
    #[Override]
    public function getCasts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(UnitTask::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(UnitLearningMaterial::class)->orderBy('order');
    }
}
