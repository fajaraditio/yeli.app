<?php

namespace Database\Seeders;

use App\Models\Bloom;
use Illuminate\Database\Seeder;

class BloomSeeder extends Seeder
{
    public function run(): void
    {
        $blooms = [
            ['name' => 'Analyze', 'color' => '#1D4ED8'],
            ['name' => 'Evaluate', 'color' => '#0F766E'],
            ['name' => 'Evaluate / Infer', 'color' => '#7C3AED'],
            ['name' => 'Create', 'color' => '#171F2E'],
        ];

        foreach ($blooms as $bloom) {
            Bloom::updateOrCreate(
                ['name' => $bloom['name']],
                ['color' => $bloom['color']]
            );
        }
    }
}
