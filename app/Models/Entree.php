<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entree extends Model
{
    use HasFactory;

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QrCode::class);

    }
}
