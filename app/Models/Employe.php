<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property Company $company
 */
class Employe extends Model
{
    use HasFactory;

    protected $fillable = ["pointeur","prenom","nom","sexe","telephone","email","id","company_id","disabled","poste","badge_autorise"];

    public static function requiredLoggedInEmploye(): Employe
    {
        $employe = Employe::find(request()->header('Employe-id'));
        if ($employe == null){
            throw new NotFoundHttpException("Unable to find employe with id given ".request()->header('employe_id'));
        }
        return $employe;

    }

    public function company() : BelongsTo
    {
        return  $this->belongsTo(Company::class);

    }

    public function appareils(): HasMany
    {
        return $this->hasMany(Appareil::class);

    }
    protected $casts = ["pointeur" => 'boolean',"badge_autorise"=>"boolean","telephone" => "integer"];

    public function horaires(): HasMany
    {
        return $this->hasMany(HoraireEmploye::class);

    }

    public function isBadgeAllowed(): bool
    {
        return (boolean) $this->attributes["badge_autorise"];

    }

    /** @noinspection PhpUnused */
    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->attributes["prenom"].' '.$this->attributes["nom"]
        );
    }
    protected $appends = ["full_name"];
}
