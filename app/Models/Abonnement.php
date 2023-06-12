<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Abonnement extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable =["date_expir"];
    protected $casts = ["date_expir" => "datetime"];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }
    public function formule(): BelongsTo
    {
        return $this->belongsTo(Formule::class);

    }
    /**
     * @noinspection PhpUnused
     */
    public function isActive(): bool{

        return ! Carbon::create($this->date_expir)->isPast();
    }

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
