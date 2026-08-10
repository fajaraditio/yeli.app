<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class UnitLearningMaterial extends Model
{
    #[Override]
    public function getCasts()
    {
        return [
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

    public function isReadBy(User $user): bool
    {
        return $this->reads()
            ->where('user_id', $user->id)
            ->whereNotNull('read_at')
            ->exists();
    }

    public function markReadBy(User $user): void
    {
        $this->reads()->updateOrCreate(
            ['user_id' => $user->id],
            ['read_at' => now()]
        );
    }
}
