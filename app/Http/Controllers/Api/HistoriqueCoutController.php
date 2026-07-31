<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoriqueCout;
use Illuminate\Http\Request;

class HistoriqueCoutController extends Controller
{
    public function index(Request $request)
    {
        $query = HistoriqueCout::with('produit')->orderBy('created_at', 'desc');

        if ($request->has('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        return $query->get();
    }
}