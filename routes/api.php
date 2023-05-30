<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppareilController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\JourneeController;
use App\Http\Controllers\SortieController;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', function (Request $request){
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
        return response(request()->user()->createToken("name"));
    }else{

        return response("Invalid credentials")->setStatusCode(401);
    }

});
Route::middleware("auth:sanctum")->group(function() {
    Route::get("pointages/{date}",[JourneeController::class,"pointages"]);
    Route::resource('employes', EmployeeController::class);
    Route::get('employes/{employe}/rapport/{dateStart}/{dateEnd}', [EmployeeController::class,"rapport"]);
    Route::resource('qr_code', QrCode::class);
    Route::resource('appareils', AppareilController::class,["only" => "destroy"]);
    Route::resource('entrees', EntreeController::class,["only" => "store"]);
    Route::resource('sorties', SortieController::class,["only" => "store"]);
});
