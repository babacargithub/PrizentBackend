<?php

namespace App\Http\Controllers;

use App\Models\Appareil;
use Illuminate\Http\Response;

class AppareilController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param Appareil $appareil
     * @return Response
     */
    public function destroy(Appareil $appareil)
    {
        $appareil->delete();
        return new Response('deleted');
    }
}
