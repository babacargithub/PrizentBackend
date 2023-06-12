<?php

namespace App\Http\Controllers\Admin;

use App\Models\Abonnement;
use App\Models\Company;
use App\Models\Payment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Carbon;

class BadgeController extends CrudController
{
    //
    public function index()
    {
        return view('admin.badges',[
        ]);

    }
}
