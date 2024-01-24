<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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

        Status::firstOrCreate([
            "type_id" => $this->getTypeByStr('user-active-type')->id,
            "name" => "Active",
            "description" => "status for user active",
            "str" => "status-active-user",
        ]);

        Status::firstOrCreate([
            "type_id" => $this->getTypeByStr('user-inactive-type')->id,
            "name" => "Inactive",
            "description" => "status for user inactive",
            "str" => "status-inactive-user",
        ]);

       
    }
}
