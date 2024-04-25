<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointage extends Model
{
    const POINTAGE_ENTREE = 'in';
    const POINTAGE_SORTIE = 'out';
    use HasFactory;

    protected $fillable = ["scanned_at","qr_code_id","employe_id","journee_id",'type'];

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

    public function calculerPonctualite() : self {
        $day = $this->journee->calendrier->dayOfWeekIso;
        $horaire = $this->employe->horaires()->where("jour",$day)->firstOrFail();
        $tempsActuel = Carbon::now();
        $horaireEntree = $horaire->entree;
        $horaireSortie = $horaire->sortie;
        $ponctualite = $this->type == self::POINTAGE_ENTREE ?
            $tempsActuel->diffInMinutes($horaireEntree, false)
        : $horaireSortie->diffInMinutes($tempsActuel, false);
        $this->attributes["ponctualite"] = $ponctualite;
        /*dd($horaireSortie, $tempsActuel, $ponctualite,$horaireEntree,$tempsActuel->diffInMinutes($horaireEntree,
            false),$horaireSortie->diffInMinutes($tempsActuel, false));*/

        return $this;

    }

    /** @noinspection PhpUnused */
    public function scopeEntree($query): Builder
    {
        return $query->whereHas("employe", function ($query) {
            $query->where("company_id", Company::requireLoggedInCompany()->id);
        })->where("type", self::POINTAGE_ENTREE);
    }

    /** @noinspection PhpUnused */
    public function scopeSortie($query): Builder
    {
        return $query->whereHas("employe", function ($query) {
            $query->where("company_id", Company::requireLoggedInCompany()->id);
        })->where("type", self::POINTAGE_SORTIE);
    }
}
