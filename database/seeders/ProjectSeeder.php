<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory(10)->create()->each(function ($project) {
            $users = User::inRandomOrder()->limit(rand(1, 5))->pluck('id');
            $project->users()->attach($users);
        });

    }
}
