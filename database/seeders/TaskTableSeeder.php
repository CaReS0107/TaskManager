<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hightPriority = Priority::where('priority_name', 'hPriority')->first();
        $mediumpriority = Priority::where('priority_name', 'mPriority')->first();
        $lowPriority = Priority::where('priority_name', 'lPriority')->first();

        $hPriority = Task::create([
            'task_name'=>'Log in acces',
            'task_desc'=>'Make login, til end of the day',
            'status'=>false,

        ]);
        $mPriority = Task::create([
            'task_name'=>'OAtuh',
            'task_desc'=>'display token in json',
            'status'=>true,

        ]);
        $lPriority = Task::create([
            'task_name'=>'Responsive mobile navbar',
            'task_desc'=>'Make nav bar responsive for android device',
            'status'=>false,

        ]);
        $hPriority->priorities()->attach($hightPriority);
        $mPriority->priorities()->attach($mediumpriority);
        $lPriority->priorities()->attach($lowPriority);

        $hPriority->projects()->attach($hightPriority);
        $mPriority->projects()->attach($mediumpriority);
        $lPriority->projects()->attach($lowPriority);



    }
}
