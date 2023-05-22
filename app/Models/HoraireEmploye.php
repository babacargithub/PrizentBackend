<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoraireEmploye extends Model
{
    protected $table = "horaires_employes";
    use HasFactory;

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }
}
