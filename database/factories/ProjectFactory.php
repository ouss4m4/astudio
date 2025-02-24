<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->word.' '.$this->faker->randomElement(['System', 'Platform', 'Solution', 'Framework', 'Integration']),
            'status' => $this->faker->randomElement(['todo', 'progress', 'done']),
        ];
    }
}
