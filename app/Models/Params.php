<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Params extends Model
{
    use HasFactory;
    const PARAM_NOTIFICATION_ENTREE = "Notification Entrée";
    const PARAM_NOTIFICATION_SORITE = "Notification Pointage";
    protected $fillable = ["nom","constant_name","disabled"];
    public $timestamps = false;

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);

    }
}
