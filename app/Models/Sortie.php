<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @Property $journee
 */
class Sortie extends Model
{
    use HasFactory;




    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }
    public function journee(): BelongsTo
    {
        return $this->belongsTo(Journee::class);

    }
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QrCode::class);

    }
    /** @noinspection UnknownColumnInspection */
    public function calculerPonctualite() : self {
        $day = $this->journee->calendrier->dayOfWeekIso;
        $horaire = $this->employe->horaires()->where("jour",$day)->first();
        $tempsActuel = Carbon::now();
        $horaireSortie = $horaire->sortie;
        $ponctualite = $horaireSortie->diffInMinutes($tempsActuel, false);
        $this->attributes["ponctualite"] = $ponctualite;

        return $this;

    }
}
