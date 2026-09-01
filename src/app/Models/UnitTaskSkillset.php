<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;

class UnitTaskSkillset extends Model
{
    #[Override]
    public function getCasts()
    {
        return [
            'question' => AsCollection::class,
        ];
    }

    #[Override]
    protected static function booted()
    {
        static::creating(function (UnitTaskSkillset $unit) {
            $latest = static::max('order_number');

            $unit->order_number = $latest ? $latest + 1 : 1;
        });
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function task_skillset(): BelongsTo
    {
        return $this->belongsTo(TaskSkillset::class);
    }
}
