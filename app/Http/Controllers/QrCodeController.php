<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\StoreQrCodeRequest;
use App\Http\Requests\UpdateQrCodeRequest;
use App\Models\Company;
use App\Models\QrCode;
use Illuminate\Http\Response;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return QrCode[]
     */
    public function index()
    {
        //
        return QrCode::where("company_id", Company::requireLoggedInCompany()->id)->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQrCodeRequest $request
     * @return Response
     */
    public function store(StoreQrCodeRequest $request)
    {
        //
        $request->validate($request->rules());
        return  QrCode::create($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param QrCode $qrCode
     * @return QrCode
     */
    public function show(QrCode $qrCode)
    {
        //
        return $qrCode;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQrCodeRequest $request
     * @param QrCode $qrCode
     * @return QrCode
     */
    public function update(UpdateQrCodeRequest $request, QrCode $qrCode)
    {
        //
        $request->validate($request->rules());
          $qrCode->update($request->input());
          return  $qrCode;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param QrCode $qrCode
     * @return Response
     */
    public function destroy(QrCode $qrCode)
    {
        //
        $qrCode->delete();
        return new Response("deleted");
    }
}
