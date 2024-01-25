<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypeSeeder::class,
            StatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
        ]);

        User::factory()->count(50)->create(); // create 50 students

        $this->call([
            TaskSeeder::class,
        ]);

    }
}
