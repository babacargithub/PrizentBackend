<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * @noinspection PhpUnused
     */
    public function isActive(): bool{

        return ! Carbon::create($this->date_expir)->isPast();
    }
}
