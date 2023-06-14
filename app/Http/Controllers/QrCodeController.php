<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\StoreQrCodeRequest;
use App\Http\Requests\UpdateQrCodeRequest;
use App\Http\Resources\QrCodeResource;
use App\Models\AppParams;
use App\Models\Company;
use App\Models\QrCode;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //
        return QrCodeResource::collection(QrCode::where("company_id", Company::requireLoggedInCompany()->id)->get());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQrCodeRequest $request
     * @return QrCode
     */
    public function store(StoreQrCodeRequest $request)
    {
        $QrCode = new  QrCode($request->input());
        $max = (integer) QrCode::max("number");
        $QrCode->number =  $max> 0? $max+1 : 20001;
        $QrCode->maximum_distance = AppParams::first()->maximum_distance;
        $QrCode->company()->associate(Company::requireLoggedInCompany());
        $QrCode->save();

        return  $QrCode;
    }

    /**
     * Display the specified resource.
     *
     * @param QrCode $qrCode
     * @return QrCode
     */
    public function show(QrCode $qrCode)
    {
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
