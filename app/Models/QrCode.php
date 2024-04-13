<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    use HasFactory;
    const TYPE_ENTREE = 'in';
    const TYPE_SORTIE = 'out';
    protected $fillable = ["nom","longitude","latitude","type","disabled"];
    protected $casts = ["disabled" => "boolean"];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }

    public function getMaximumDistanceAttribute(): int
    {

        return AppParams::first()->maximum_distance?? 100;

    }
    protected $appends = ["maximum_distance"];
}
