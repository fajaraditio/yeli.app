<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskSkillset extends Model
{
    public $timestamps = false;

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function skillset(): BelongsTo
    {
        return $this->belongsTo(Skillset::class);
    }
}
