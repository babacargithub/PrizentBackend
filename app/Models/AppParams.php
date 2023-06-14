<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppParams extends Model
{
    protected $fillable = ["maximum_distance"];
    protected $casts = ["maximum_distance"=>"integer"];
}
