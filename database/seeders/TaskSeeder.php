<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = collect(
            ['name' => fake()->text(30), 'description' => fake()->text(100)],
            ['name' => fake()->text(30), 'description' => fake()->text(100)],
            ['name' => fake()->text(30), 'description' => fake()->text(100)],
        );

        foreach ($tasks as $key => $task) {
            $task = Task::create([]);
        }

        $students = Student::all()->map(function ($student) {
            $tasks = Task::all()->map(function ($task) use ($student) {
                $student->tasks()->attach($task->id, ['qualification' => random_int(5, 10)]);
            });
        });
    }
}
