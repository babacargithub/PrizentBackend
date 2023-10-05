<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property integer $commercial_id
 * @property Commercial $commercial
 */
class Company extends Model
{
    use CrudTrait;
    protected $table = "companies";
    use HasFactory;
    protected $fillable = ["nom","email","latitude","longitude","telephone"];

    /**
     * @noinspection PhpUnused
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @noinspection PhpUnused
     */
    public function commercial() : BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }

    public function abonnement(): HasOne
    {
        return $this->hasOne(Abonnement::class);

    }
    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);

    }

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);

    }

    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Params::class)
            ->using(CompanyParams::class)
            ->withPivot("enabled");


    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);

    }

    public static  function requireLoggedInCompany() : Company {
        $user = request()->user();
        if ($user == null){
            throw new NotFoundHttpException("User is null unable to find company with user account id");
        }
        $company = Company::where('user_id', $user->id)->first();
        if ($company == null){
            $company = Company::whereRelation("users",'users.id',request()->user()->id)->first();
            if ($company == null){
            throw new NotFoundHttpException("Unable to find company with user account id");
            }
        }
        return $company;
    }
    public function hasActiveSubscription(): bool
    {
        return $this->abonnement != null && $this->abonnement->isActive();
    }

    public function __toString() : string
    {
        return  (string) $this->attributes["nom"];

    }
}
