<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $telephone
 * @property User $user
 * @property string $email
 * @property string $sexe
 * @property Company[] $companies
 */
class Commercial extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = ["nom","telephone","email","sexe"];
    /**
     * @noinspection PhpUnused
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);

    }

}
