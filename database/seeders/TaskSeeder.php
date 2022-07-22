<?php

namespace Database\Seeders;

use App\Models\Reviews;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 
        Task::factory(20)->create();

        $tasks = Task::all();
        foreach ($tasks as $task) {
          $_user = $task->user->id;
          $users = User::where('id', '!=', $_user)->get()->pluck('id');
          Reviews::factory(2)->state([
            'user_id' => $users[random_int(0, count($users)-1)],
            'task_id' => $task->id
          ])->create();
        }
    }
}
