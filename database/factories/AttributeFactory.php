<?php

namespace Database\Factories;

// use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    // protected $model = Attribute::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['department', 'start_date', 'end_date']),
            'type' => $this->faker->randomElement(['text', 'date', 'number', 'select']),
        ];

    }
}
