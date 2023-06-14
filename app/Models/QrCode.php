<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    use HasFactory;
    const TYPE_ENTREE = 1;
    const TYPE_SORTIE = 2;
    protected $fillable = ["nom","longitude","latitude","type","disabled"];
    protected $casts = ["disabled" => "boolean"];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }

    public function getMaximumDistanceAttribute(): int
    {

        return AppParams::first()->maximum_distance?? 1000;

    }
    protected $appends = ["maximum_distance"];
}
