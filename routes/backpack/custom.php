<?php

use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\RapportController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('formule', 'FormuleCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('abonnement', 'AbonnementCrudController');
    Route::get("rapports",[RapportController::class,"rapports"])->name('rapport.index');
    Route::get("badges",[BadgeController::class,"index"])->name('rapport.index');
    Route::get("qr_codes",[BadgeController::class,"index"])->name('qr-codes.index');
    Route::get("soldes",[RapportController::class,"soldes"])->name('soldes.solde');
    Route::get("stats",[RapportController::class,"stats"])->name('stats.stats');

}); // this should be the absolute last line of this file
