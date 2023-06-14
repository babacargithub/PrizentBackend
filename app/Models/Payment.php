<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use CrudTrait;
    use HasFactory;
    const PAYEMENT_METHOD_WAVE = "WAVE",
        PAYMENT_METHOD_OM = "OM",
        PAYMENT_METHOD_CASH = "CASH";
    protected $fillable = ["montant","paye_par"];

    public function abonnement(): BelongsTo
    {
        return $this->belongsTo(Abonnement::class);

    }
}
