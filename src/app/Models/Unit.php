<?php

namespace App\Models;

use App\Constants\UnitConstant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class Unit extends Model
{
    #[Override]
    protected static function booted()
    {
        static::creating(function (Unit $unit) {
            $latest = static::max('order');

            $unit->order = $latest ? $latest + 1 : 1;
        });
    }

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
