<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appareil extends Model
{
    protected $table ="appareils";
    protected $fillable = ["uuid","name","last_active"];
    use HasFactory;

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }

}
