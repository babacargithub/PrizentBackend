<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\JourneeController;
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
    Route::resource('appareils', DeviceController::class,["only" => "destroy"]);
});
