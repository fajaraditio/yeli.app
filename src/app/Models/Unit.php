<?php

namespace App\Models;

use App\Constants\UnitConstant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    public function stages(): HasMany
    {
        return $this->hasMany(UnitStage::class);
    }

    // Lecturers (and Students, once unlocked) only ever see Published units.
    // No per-lecturer assignment check — access is status-based, not ownership-based.
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', UnitConstant::Status_Published);
    }
}
