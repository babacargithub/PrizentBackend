<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CrudTrait;
    protected $table = "companies";
    use HasFactory;
    protected $fillable = ["nom","email","latitude","longitude","telephone"];
}
