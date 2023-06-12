<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    use HasFactory;
    const FEATURE_PHYSICAL_BADGE = "physical_badge";
    const FEATURE_LOCATION_CONSTRAINT = "location_constraint";
    const FEATURE_POINTAGE = "pointage";
    const FEATURE_REPORTS = "reports";
    const FEATURE_RANKINGS = "rankings";
    const FEATURE_SMS_NOTIFICATIONS = "sms_notifications";
    const FEATURE_REPORT_EXPORT = "report_export";
    const FEATURE_MULTIPLE_ACCOUNT = "multiple_account";
    public function formules() : BelongsToMany {
        return  $this->belongsToMany(Formule::class);
    }
}
