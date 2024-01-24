<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'isela martinez',
            'email' => 'imartinez@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status_id' => Status::whereStr('status-active-user')->first()->id,
            'role_id' => Role::whereStr('teacher-role')->first()->id,
            'birthdate' => Carbon::now(),
            'age' => 40,
        ]);

        $a = 0;
        while ($a < 2) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'status_id' => Status::whereStr('status-active-user')->first()->id,
                'role_id' => Role::whereStr('teacher-role')->first()->id,
                'birthdate' => Carbon::now(),
                'age' => random_int(30, 70),
            ]);
            $a++;
        }
    }
}
