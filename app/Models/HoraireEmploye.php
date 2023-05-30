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
    protected $fillable = ["jour","sortie","entree","repos"];
    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }
    protected $dates = ["entree","sortie"];

}
