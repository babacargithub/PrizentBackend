<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Appareil;
use Illuminate\Http\Response;

class DeviceController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appareil  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appareil $appareil)
    {
        $appareil->delete();
        return new Response('deleted');
    }
}
