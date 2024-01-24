<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "type_id",
        "name",
        "description",
        "str",
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }
}
