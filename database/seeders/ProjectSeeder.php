<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory(2)->create()->each(function ($project) {
            $users = User::inRandomOrder()->limit(rand(1, 2))->pluck('id');
            $project->users()->attach($users);
        });

    }
}
