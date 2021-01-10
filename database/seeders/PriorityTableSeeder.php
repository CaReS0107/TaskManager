<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::truncate();

        Priority::create([
            'priority_name' => 'hPriority',
            'status' => true
        ]);
        Priority::create([
            'priority_name' => 'mPriority',
            'status' => true
        ]);
        Priority::create([
            'priority_name' => 'lPriority',
            'status'=>true
        ]);
    }
}
