<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $telephone
 * @property User $user
 * @property string $email
 * @property string $sexe
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

}
