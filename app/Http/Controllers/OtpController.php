<?php

namespace App\Http\Controllers;

use App\Models\Appareil;
use App\Models\CodeOtp;
use App\Models\Employe;
use App\Rules\PhoneNumber;
use App\Services\SMSSender;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OtpController extends Controller
{

    public function fetchOtp(Request $request){
        $data = $request->validate([
            'phone_number' => ["required", new PhoneNumber()],
        ]);

        $employe = Employe::whereTelephone($data["phone_number"])->first();
        if ($employe == null){

            return response()->json(["message"=>"Aucun compte lié avec ce numéro !"], 422);
        }
        CodeOtp::wherePhoneNumber($data["phone_number"])->delete();
        $codeOtpGenerated = mt_rand(1111,9999);
        $qrCode = CodeOtp::create(["otp" => $codeOtpGenerated,"phone_number" => $data["phone_number"],"expires_at" => Carbon::now()->addMinutes(15)]);

        SMSSender::sendSms($qrCode->phone_number, $qrCode->otp." est votre code OTP Prizent. Valable pour 15 minutes ");
        return response()->json(["message"=>"otp sent"]);


    }
    public function checkOtp(Request $request){
        $data = $request->validate([
            'otp' => "required|integer|max_digits:4|min_digits:4",
            'phone_number' => ["required", new PhoneNumber()],
            "device"=> "required|array"

        ]);
        $otpCode = CodeOtp::wherePhoneNumber($data["phone_number"])
            ->whereOtp($data['otp'])
            ->first();
        if ($otpCode != null){
            if($otpCode->expired())
            return response()->json(["message"=>"Code expiré !"], 422);
        }else{
            return response()->json(["message"=>"Code invalide !"], 422);
        }
        $employe = Employe::whereTelephone($data["phone_number"])->first();
        $employe->load("badge");

        $device = new Appareil($data["device"]);
        if ($employe->appareils()->count() > 0){
            $device = $employe->appareils()->whereUuid($device->uuid)->first();
            if ($device != null){
                return response()->json(["message"=>"otp ok","employe"=>$employe]);

            }
            else {
                return response()->json(["message"=>"Déjà connecté sur un autre appareil","employe"=>$employe], 422);

            }
        }else{
            $employe->appareils()->save($device);
        }

        return response()->json(["message"=>"otp ok","employe"=>$employe]);

    }
}
