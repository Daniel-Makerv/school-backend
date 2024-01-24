<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionSeeder extends Seeder
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
        Permission::firstOrCreate([
            "type_id" => $this->getTypeByStr('type-permission-teacher')->id,
            "name" => "list students",
            "description" => "permission to list students",
            "str" => "list-students-permission",
        ]);

        Permission::firstOrCreate([
            "type_id" => $this->getTypeByStr('type-permission-teacher')->id,
            "name" => "create student",
            "description" => "permission to create student",
            "str" => "create-student-permission",
        ]);

        Permission::firstOrCreate([
            "type_id" => $this->getTypeByStr('type-permission-teacher')->id,
            "name" => "edit student",
            "description" => "permission to edit student",
            "str" => "edit-student-permission",
        ]);

        Permission::firstOrCreate([
            "type_id" => $this->getTypeByStr('type-permission-teacher')->id,
            "name" => "delete student",
            "description" => "permission to delete student",
            "str" => "delete-student-permission",
        ]);

        Permission::all()->map(function ($permission) {
            $role = Role::whereStr('teacher-role')->first();
            $role->permissions()->attach($permission->id);
        });
    }
}
