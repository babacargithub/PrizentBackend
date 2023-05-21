<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use CrudTrait;
    protected $table = "companies";
    use HasFactory;
    protected $fillable = ["nom","email","latitude","longitude","telephone"];

    /**
     * @noinspection PhpUnused
     */
    public function userAccount() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
