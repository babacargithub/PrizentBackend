<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Badge extends Model
{
    protected $fillable = ["number","belongs_to_batch","last_used_at"];
    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);

    }

    public function isDisabled(): bool
    {
        return (bool) $this->attributes["disabled"];
    }
}
