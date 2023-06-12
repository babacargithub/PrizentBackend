<?php

namespace App\Http\Controllers\Admin;

use App\Rules\PhoneNumber;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class QrCodeAdminController extends CrudController
{
    //
    public function index()
    {
        return view('admin.qr_codes',[
        ]);

    } public function link(Request $request)
    {
        $request->validate([
            "company_telephone"=>["required", new PhoneNumber(false)],
            "qr_code_number"=>["required", "int"],
            "latitude"=>["required", "numeric"],
            "longitude"=>["required", "numeric"],
            ]);
        return view('admin.qr_codes',[
        ]);

    }
    public function generate()
    {
        return view('admin.qr_codes',[
        ]);

    }
    public function unused()
    {
        return view('admin.qr_codes',[
        ]);

    }
}
