<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimesheetFactory extends Factory
{
    public function definition(): array
    {

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'project_id' => Project::inRandomOrder()->first()->id ?? Project::factory(),
            'task_name' => $this->faker->randomElement(['Development', 'Testing', 'Deployment', 'Research', 'Design', 'Implementation']).' '.$this->faker->word,
            'date' => $this->faker->date,
            'hours' => $this->faker->randomFloat(2, 1, 8), // Hours between 1 and 8
        ];
    }
}
