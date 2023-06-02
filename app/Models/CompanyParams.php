<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyParams extends Pivot
{
protected $casts = ["enabled"=>"boolean"];
}
