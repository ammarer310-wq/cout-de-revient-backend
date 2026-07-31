<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PricingService;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function calcul(
        Request $request,
        PricingService $service
    )
    {
        return response()->json(

            $service->calculer(

                $request->cout_unitaire,

                $request->prix_vente
            )
        );
    }
}
