<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\MatierePremiereController;
use App\Http\Controllers\Api\HistoriquePrixController;
use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\Api\RecetteController;
use App\Http\Controllers\Api\CostController;
use App\Http\Controllers\ChargeIndirecteController;
use App\Http\Controllers\Api\PricingController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SimulationController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\MainOeuvreController;
use App\Http\Controllers\Api\PackagingController;
use App\Http\Controllers\Api\PrixVenteController;
use App\Http\Controllers\Api\HistoriqueCoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Routes publiques (auth)
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// --- Lecture : accessible a tout utilisateur connecte ---
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('produits', ProduitController::class)->only(['index', 'show']);
    Route::apiResource('matierepremiere', MatierePremiereController::class)->only(['index', 'show']);
    Route::apiResource('historiqueprix', HistoriquePrixController::class)->only(['index', 'show']);
    Route::apiResource('fournisseurs', FournisseurController::class)->only(['index', 'show']);
    Route::apiResource('recettes', RecetteController::class)->only(['index', 'show']);
    Route::apiResource('chargesindirectes', ChargeIndirecteController::class)->only(['index', 'show']);
    Route::apiResource('main-oeuvre', MainOeuvreController::class)->only(['index', 'show']);
    Route::apiResource('packagings', PackagingController::class)->only(['index', 'show']);
    Route::get('/historique-couts', [HistoriqueCoutController::class, 'index']);

    Route::get('cout/{id}', [CostController::class, 'calcul']);
    Route::post('/pricing/calculate', [PricingController::class, 'calcul']);
    Route::post('/simulation', [SimulationController::class, 'simuler']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/kpi', [DashboardController::class, 'kpi']);
});

// --- Ecriture / actions sensibles : reserve aux admins ---
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('produits', ProduitController::class)->except(['index', 'show']);
    Route::apiResource('matierepremiere', MatierePremiereController::class)->except(['index', 'show']);
    Route::apiResource('historiqueprix', HistoriquePrixController::class)->except(['index', 'show']);
    Route::apiResource('fournisseurs', FournisseurController::class)->except(['index', 'show']);
    Route::apiResource('recettes', RecetteController::class)->except(['index', 'show']);
    Route::apiResource('chargesindirectes', ChargeIndirecteController::class)->except(['index', 'show']);
    Route::apiResource('main-oeuvre', MainOeuvreController::class)->except(['index', 'show']);
    Route::apiResource('packagings', PackagingController::class)->except(['index', 'show']);

    Route::post('/produits/{id}/prix-vente', [PrixVenteController::class, 'enregistrer']);
    Route::get('/export/excel', [ReportController::class, 'exportExcel']);
    Route::get('/export/pdf', [ReportController::class, 'exportPdf']);
});