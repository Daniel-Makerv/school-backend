<?php

namespace App\Helpers\Student;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Seller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Redis;

class StudentHelper
{

    public static function generateEnrollment($user)
    {

        return config('app.identify_school_id') . $user->id;
    }
}
