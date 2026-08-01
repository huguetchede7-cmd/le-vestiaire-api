<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function stats()
    {
        if (Auth::guard('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Acces reserve aux administrateurs.'], 403);
        }

        $chiffreAffaires = Commande::whereIn('statut', ['validee', 'en_preparation', 'expediee', 'livree'])
            ->sum('montant_total');

        $commandesParStatut = Commande::selectRaw('statut, count(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        return response()->json([
            'total_produits' => Produit::count(),
            'total_categories' => Categorie::count(),
            'total_commandes' => Commande::count(),
            'total_clients' => User::where('role', 'client')->count(),
            'chiffre_affaires' => $chiffreAffaires,
            'commandes_par_statut' => $commandesParStatut,
            'dernieres_commandes' => Commande::with('user')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}