<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainOeuvre;
use Illuminate\Http\Request;

class MainOeuvreController extends Controller
{
    public function index()
    {
        return MainOeuvre::with('produit')->get();
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
    'produit_id' => 'required|exists:produits,id',
    'nom' => 'nullable|string|max:100',
    'cout_horaire' => 'required|numeric|min:0',
    'temps_minutes' => 'required|numeric|min:0',
]);

        return MainOeuvre::create($validated);
    }

    public function show(string $id)
    {
        return MainOeuvre::with('produit')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $mainOeuvre = MainOeuvre::findOrFail($id);

        $validated = $request->validate([
    'produit_id' => 'required|exists:produits,id',
    'nom' => 'required|max:100',
    'cout_horaire' => 'required|numeric|min:0',
    'temps_minutes' => 'required|numeric|min:0',
]);

        $mainOeuvre->update($validated);

        return $mainOeuvre;
    }

    public function destroy(string $id)
    {
        MainOeuvre::findOrFail($id)->delete();

        return response()->json(['message' => 'Main d\'oeuvre supprimee']);
    }
}