<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::factory()->create(['name' => 'department', 'type' => 'text']);
        Attribute::factory()->create(['name' => 'start_date', 'type' => 'date']);
        Attribute::factory()->create(['name' => 'end_date', 'type' => 'date']);
    }
}
