<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ["calendrier","name","ferie"];
    protected $dates = ["calendrier"];


}
