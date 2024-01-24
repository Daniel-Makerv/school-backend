<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleSeeder extends Seeder
{

    public function getTypeByStr($str): Model
    {
        return Type::whereStr($str)->first();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::firstOrCreate([
            "type_id" => $this->getTypeByStr('role-type-teacher')->id,
            "name" => "teacher",
            "description" => "rol to teacher",
            "str" => "teacher-role",
        ]);

        Role::firstOrCreate([
            "type_id" => $this->getTypeByStr('role-type-student')->id,
            "name" => "student",
            "description" => "role type student",
            "str" => "student-role",
        ]);
    }
}
