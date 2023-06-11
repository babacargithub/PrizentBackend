<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\AppareilController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JourneeController;
use App\Http\Controllers\Mobile\MobileAppController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\QrCodeController;
use App\Http\Middleware\CheckIfHasActiveSubscription;
use App\Http\Middleware\MobileAppRequest;
use App\Models\Company;
use Carbon\Carbon;
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

// anonymous and unauthenticated routes

Route::post('/login', function (Request $request){
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
        $token = request()->user()->createToken("name", [], Carbon::now()->addDays(30));
        $company  = Company::where('user_id', request()->user()->id)->first();
        return response(["token"=>$token,"company"=>$company]);
    }else{

        return response("Invalid credentials")->setStatusCode(401);
    }

});
Route::prefix("mobile/") ->group(function () {
    Route::post('/fetch_otp', [OtpController::class, "fetchOtp"]);

    Route::post('/check_otp', [OtpController::class, "checkOtp"]
    );
});

// mobile app requests
Route::prefix("mobile/")
    ->middleware([MobileAppRequest::class])
    ->group(function (){
        Route::get('employes/{id}', [MobileAppController::class, "employe"]);
        Route::get('qr_code_scanned/{qrCode}', [MobileAppController::class, "getQrCode"]);
        Route::post('pointage', [MobileAppController::class, "pointer"]);
        Route::post('pointage_badge', [MobileAppController::class, "pointerUnBadge"]);
        Route::get('pointages', [MobileAppController::class, "pointages"]);

    });



// company app authenticated routes
Route::middleware(["auth:sanctum", CheckIfHasActiveSubscription::class])->group(function() {
    Route::get("pointages/{date}",[JourneeController::class,"pointages"]);
    Route::get('employes/{employe}/rapport/{dateStart}/{dateEnd}', [EmployeeController::class,"rapport"]);
    Route::get('employes/rankings/{dateStart}/{dateEnd}', [EmployeeController::class,"rankings"]);
    Route::get('companies/pointeurs', [CompanyController::class,"pointeurs"]);
    Route::put('companies/params', [CompanyController::class,"updateParams"]);
    Route::put('companies/update', [CompanyController::class,"update"]);
    Route::get('companies/show', [CompanyController::class,"show"]);
    Route::post('companies/create_user', [CompanyController::class,"createUser"]);
    Route::get('companies/users', [CompanyController::class,"getUsers"]);
    Route::post('companies/users/{user}/update_permissions', [CompanyController::class,"updatePermissions"]);
    Route::get('companies/users/{user}/get_permissions', [CompanyController::class,"getUserPermissions"]);
    Route::put('companies/users/{user}/update', [CompanyController::class,"updateUser"]);
    Route::post('companies/users/{user}/delete', [CompanyController::class,"deleteUser"]);
    Route::resource('employes', EmployeeController::class);
    Route::resource('qr_codes', QrCodeController::class);
    Route::resource('appareils', AppareilController::class,["only" => "destroy"]);
});

// company app unauthenticated routes

Route::middleware(["auth:sanctum"])->group(function() {
    Route::get('companies/index', [CompanyController::class, "abonnementShow"]);
    Route::post('company/abonner', [AbonnementController::class, "abonnerRequest"]);
    Route::post('abonnement/{abonnement}/renouveler/initier', [AbonnementController::class, "renouveler"]);
});
