<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoraireEmploye extends Model
{
    public $timestamps = false;
    protected $table = "horaires_employes";
    use HasFactory;
    protected $fillable = ["jour","sortie","entree","repos","employe_id","sortie_lendemain"];
    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }
    protected $casts = [
        'repos' => 'boolean',
        'entree' => 'datetime:H:i',
        'sortie' => 'datetime:H:i',
        'sortie_lendemain' => 'boolean'
    ];

}
