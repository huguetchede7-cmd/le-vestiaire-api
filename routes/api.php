<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\TailleController;
use App\Http\Controllers\Api\VarianteProduitController;
use App\Http\Controllers\Api\FlocageController;
use App\Http\Controllers\Api\BadgeController;
use App\Http\Controllers\Api\EmballageController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\AdresseController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/{id}', [ProduitController::class, 'show']);

Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/categories/{id}', [CategorieController::class, 'show']);

Route::get('/tailles', [TailleController::class, 'index']);
Route::get('/tailles/{id}', [TailleController::class, 'show']);

Route::get('/variantes', [VarianteProduitController::class, 'index']);
Route::get('/variantes/{id}', [VarianteProduitController::class, 'show']);

Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/badges/{id}', [BadgeController::class, 'show']);

Route::get('/emballages', [EmballageController::class, 'index']);
Route::get('/emballages/{id}', [EmballageController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::post('/produits', [ProduitController::class, 'store']);
    Route::put('/produits/{id}', [ProduitController::class, 'update']);
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);

    Route::post('/categories', [CategorieController::class, 'store']);
    Route::put('/categories/{id}', [CategorieController::class, 'update']);
    Route::delete('/categories/{id}', [CategorieController::class, 'destroy']);

    Route::post('/tailles', [TailleController::class, 'store']);
    Route::put('/tailles/{id}', [TailleController::class, 'update']);
    Route::delete('/tailles/{id}', [TailleController::class, 'destroy']);

    Route::post('/variantes', [VarianteProduitController::class, 'store']);
    Route::put('/variantes/{id}', [VarianteProduitController::class, 'update']);
    Route::delete('/variantes/{id}', [VarianteProduitController::class, 'destroy']);

    Route::post('/flocages', [FlocageController::class, 'store']);
    Route::put('/flocages/{id}', [FlocageController::class, 'update']);
    Route::delete('/flocages/{id}', [FlocageController::class, 'destroy']);

    Route::post('/badges', [BadgeController::class, 'store']);
    Route::put('/badges/{id}', [BadgeController::class, 'update']);
    Route::delete('/badges/{id}', [BadgeController::class, 'destroy']);

    Route::post('/emballages', [EmballageController::class, 'store']);
    Route::put('/emballages/{id}', [EmballageController::class, 'update']);
    Route::delete('/emballages/{id}', [EmballageController::class, 'destroy']);

    Route::get('/adresses', [AdresseController::class, 'index']);
    Route::get('/adresses/{id}', [AdresseController::class, 'show']);
    Route::post('/adresses', [AdresseController::class, 'store']);
    Route::put('/adresses/{id}', [AdresseController::class, 'update']);
    Route::delete('/adresses/{id}', [AdresseController::class, 'destroy']);

    Route::get('/commandes', [CommandeController::class, 'index']);
    Route::get('/admin/commandes', [CommandeController::class, 'adminIndex']);
    Route::get('/commandes/{id}', [CommandeController::class, 'show']);
    Route::post('/commandes', [CommandeController::class, 'store']);
    Route::put('/commandes/{id}/statut', [CommandeController::class, 'updateStatut']);
});