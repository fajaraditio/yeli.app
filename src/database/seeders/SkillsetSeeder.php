<?php

namespace Database\Seeders;

use App\Models\Skillset;
use Illuminate\Database\Seeder;

class SkillsetSeeder extends Seeder
{
    public function run(): void
    {
        $skillsets = [
            ['name' => 'Interpretation', 'color' => '#2563EB'],
            ['name' => 'Analysis', 'color' => '#1C2438'],
            ['name' => 'Evaluation', 'color' => '#0F766E'],
            ['name' => 'Inference', 'color' => '#7C3AED'],
            ['name' => 'Explanation', 'color' => '#B7472A'],
            ['name' => 'Self-Regulation', 'color' => '#15803D'],
            ['name' => 'Foundation (LOTS)', 'color' => '#6B7280'],
        ];

        foreach ($skillsets as $skillset) {
            Skillset::updateOrCreate(
                ['name' => $skillset['name']],
                ['color' => $skillset['color']]
            );
        }
    }
}
