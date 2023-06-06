<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CodeOtp extends Model
{
    protected $table = "codes_otp";
    protected $fillable = ["phone_number","otp","expires_at"];
    protected $casts = ["expires_at" => "datetime"];

    public function expired(): bool
    {
        return $this->expires_at->isPast();

    }
}
