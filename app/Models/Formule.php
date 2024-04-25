<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Formule extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = ["nom","comment","duree","limite","prix","unite"];

    /** @noinspection PhpUnused */
    public static function scopePreDefined(Builder $query): Builder
    {
        return $query->where("custom",false);
    }

    public function features() : BelongsToMany {
        return  $this->belongsToMany(Feature::class);
    }

    public function hasFeature($feature) : bool
    {
        return  $this->features()->whereConstantName($feature)->exists();
    }
    protected $casts = [
        'custom' => 'boolean',
    ];
    public function isCustom(): bool
    {
        return (bool)$this->custom;
    }
}

