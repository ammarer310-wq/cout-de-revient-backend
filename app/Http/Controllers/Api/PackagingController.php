<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Packaging;
use Illuminate\Http\Request;

class PackagingController extends Controller
{
    public function index()
    {
        return Packaging::with('produit')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'nom' => 'required|string|max:100',
            'prix' => 'required|numeric|min:0',
        ]);

        return Packaging::create($validated);
    }

    public function show(string $id)
    {
        return Packaging::with('produit')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $packaging = Packaging::findOrFail($id);

        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'nom' => 'required|string|max:100',
            'prix' => 'required|numeric|min:0',
        ]);

        $packaging->update($validated);

        return $packaging;
    }

    public function destroy(string $id)
    {
        Packaging::findOrFail($id)->delete();

        return response()->json(['message' => 'Packaging supprime']);
    }
}