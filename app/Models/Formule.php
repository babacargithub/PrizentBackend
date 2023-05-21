<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Formule extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = ["nom","comment","duree","limite","prix","unite"];
    public function features() : BelongsToMany {
        return  $this->belongsToMany(Feature::class);
    }
}
