<?php

namespace App\Http\Controllers;

use App\Models\ChargeIndirecte;
use Illuminate\Http\Request;

class ChargeIndirecteController extends Controller
{
    public function index()
    {
        return response()->json(
            ChargeIndirecte::all()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'montant' => 'required|numeric',
            'methode_repartition' => 'required'
        ]);

        $charge = ChargeIndirecte::create(
            $request->all()
        );

        return response()->json(
            $charge,
            201
        );
    }

    public function show($id)
    {
        return ChargeIndirecte::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $charge =
            ChargeIndirecte::findOrFail($id);

        $charge->update(
            $request->all()
        );

        return response()->json($charge);
    }

    public function destroy($id)
    {
        ChargeIndirecte::destroy($id);

        return response()->json([
            'message' => 'Supprimé'
        ]);
    }
}