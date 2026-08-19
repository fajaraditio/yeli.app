<?php

namespace Database\Seeders;

use App\Models\Skillset;
use App\Models\Task;
use App\Models\TaskSkillset;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Pre-task',
                'description' => 'A short authentic cose that triggers interpretotion before the core input.',
                'skillsets' => ['Interpretation'],
            ],
            [
                'name' => 'Core Input',
                'description' => 'Reading/listening text plus on integrated glossary (LOTS foundation)',
                'skillsets' => ['Foundation (LOTS)'],
            ],
            [
                'name' => 'Whilst-Task',
                'description' => 'Analysis, evaluation and in ference tasks tied to Focione\'s indicators.',
                'skillsets' => ['Analysis', 'Evaluation', 'Inference'],
            ],
            [
                'name' => 'Post-Task',
                'description' => 'A problem-solving project applying the torget language',
                'skillsets' => ['Explanation'],
            ],
            [
                'name' => 'Reflection',
                'description' => 'A short reflective journal entry to close the unit',
                'skillsets' => ['Self-Regulation'],
            ],
        ];

        $orderNumber = 1;
        foreach ($tasks as $taskList) {
            $task = Task::updateOrCreate(
                [
                    'name' => $taskList['name']
                ],
                [
                    'description' => $taskList['description'],
                    'order_number' => $orderNumber
                ]
            );

            foreach ($taskList['skillsets'] as $taskSkillset) {
                $skillset = Skillset::where('name', $taskSkillset)->first();

                TaskSkillset::updateOrCreate(
                    [
                        'task_id' => $task->id,
                        'skillset_id' => $skillset->id,
                    ],
                    [
                        'skillset_name' => $skillset?->name,
                        'skillset_color' => $skillset?->color
                    ]
                );
            }

            $orderNumber++;
        }
    }
}
