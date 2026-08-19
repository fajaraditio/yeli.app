<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    public function task_skillsets(): HasMany
    {
        return $this->hasMany(TaskSkillset::class);
    }

    public function skillsets(): BelongsToMany
    {
        return $this->belongsToMany(Skillset::class, 'task_skillsets', 'task_id', 'skillset_id');
    }
}
