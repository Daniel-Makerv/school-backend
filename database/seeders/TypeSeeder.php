<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::firstOrCreate([
            "name" => "status",
            "description" => "type status",
            "str" => "type-status"
        ]);

        Type::firstOrCreate([
            "name" => "Active user",
            "description" => "type user active",
            "str" => "user-active-type"
        ]);
        Type::firstOrCreate([
            "name" => "Inactive user",
            "description" => "type user inactive",
            "str" => "user-inactive-type"
        ]);

        Type::firstOrCreate([
            "name" => "role teacher",
            "description" => "role type teacher",
            "str" => "role-type-teacher"
        ]);

        Type::firstOrCreate([
            "name" => "role student",
            "description" => "role type student",
            "str" => "role-type-student"
        ]);

        Type::firstOrCreate([
            "name" => "permission teacher",
            "description" => "type permission teacher",
            "str" => "type-permission-teacher"
        ]);

        Type::firstOrCreate([
            "name" => "permission student",
            "description" => "type permission student",
            "str" => "type-permission-student"
        ]);
    }
}
