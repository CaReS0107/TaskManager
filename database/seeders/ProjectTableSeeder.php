<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'project_name' => 'Task Manager',
            'project_desc'=>'Functions of this project is to create a project manager for users',
            'status' => true
        ]);
        Project::create([
            'project_name' => 'Recipe for Cuisine',
            'project_desc'=>'Functions of this project is to create platfor where user can add recipes',
            'status' => true
        ]);
        Project::create([
            'project_name' => 'School',
            'project_desc'=>'Functions of this project is to create a project to manage a school ',
            'status' => true
        ]);
    }
}
