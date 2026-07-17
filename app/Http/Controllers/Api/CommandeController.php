<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\VarianteProduit;
use App\Models\Flocage;
use App\Models\Badge;
use App\Models\Emballage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommandeController extends Controller
{
    // Liste des commandes du client connecté
    public function index()
    {
        $commandes = Commande::with(['lignes.varianteProduit.produit', 'lignes.varianteProduit.taille', 'paiement'])
            ->where('user_id', Auth::guard('api')->id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($commandes);
    }

    // Détail d'une commande
    public function show($id)
    {
        $commande = Commande::with([
            'lignes.varianteProduit.produit',
            'lignes.varianteProduit.taille',
            'lignes.flocage',
            'lignes.badge',
            'lignes.emballage',
            'paiement',
            'adresse',
        ])->where('user_id', Auth::guard('api')->id())->findOrFail($id);

        return response()->json($commande);
    }

    // Créer une commande à partir du panier
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'adresse_id' => 'required|exists:adresses,id',
            'methode_paiement' => 'required|in:mobile_money,a_la_livraison,carte',
            'lignes' => 'required|array|min:1',
            'lignes.*.variante_produit_id' => 'required|exists:variante_produits,id',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.flocage' => 'nullable|array',
            'lignes.*.badge_id' => 'nullable|exists:badges,id',
            'lignes.*.emballage_id' => 'nullable|exists:emballages,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return DB::transaction(function () use ($request) {
            $montantTotal = 0;
            $lignesACreer = [];

            foreach ($request->lignes as $ligne) {
                $variante = VarianteProduit::with('produit')->findOrFail($ligne['variante_produit_id']);

                if ($variante->quantite_stock < $ligne['quantite']) {
                    abort(422, "Stock insuffisant pour {$variante->produit->nom} ({$variante->sku})");
                }

                $prixLigne = $variante->produit->prix_base + $variante->prix_supplement;

                $flocageId = null;
                if (!empty($ligne['flocage'])) {
                    $flocage = Flocage::create($ligne['flocage']);
                    $flocageId = $flocage->id;
                    $prixLigne += $flocage->prix_supplement;
                }

                $badgeId = $ligne['badge_id'] ?? null;
                if ($badgeId) {
                    $prixLigne += Badge::findOrFail($badgeId)->prix;
                }

                $emballageId = $ligne['emballage_id'] ?? null;
                if ($emballageId) {
                    $prixLigne += Emballage::findOrFail($emballageId)->prix;
                }

                $sousTotal = $prixLigne * $ligne['quantite'];
                $montantTotal += $sousTotal;

                $variante->decrement('quantite_stock', $ligne['quantite']);

                $lignesACreer[] = [
                    'variante_produit_id' => $variante->id,
                    'flocage_id' => $flocageId,
                    'badge_id' => $badgeId,
                    'emballage_id' => $emballageId,
                    'quantite' => $ligne['quantite'],
                    'prix_unitaire' => $prixLigne,
                ];
            }

            $commande = Commande::create([
                'user_id' => Auth::guard('api')->id(),
                'adresse_id' => $request->adresse_id,
                'montant_total' => $montantTotal,
                'statut' => 'en_attente',
            ]);

            foreach ($lignesACreer as $ligneData) {
                $ligneData['commande_id'] = $commande->id;
                LigneCommande::create($ligneData);
            }

            $commande->paiement()->create([
                'methode' => $request->methode_paiement,
                'statut' => 'en_attente',
            ]);

            return response()->json(
                $commande->load(['lignes.varianteProduit.produit', 'paiement']),
                201
            );
        });
    }

    // Modifier le statut d'une commande (admin)
    public function updateStatut(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:en_attente,validee,en_preparation,expediee,livree,annulee',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $commande = Commande::findOrFail($id);
        $commande->update(['statut' => $request->statut]);

        return response()->json($commande);
    }
}
