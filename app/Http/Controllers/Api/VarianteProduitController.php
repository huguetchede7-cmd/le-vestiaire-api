<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VarianteProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VarianteProduitController extends Controller
{
    // Liste des variantes (avec filtre optionnel par produit)
    public function index(Request $request)
    {
        $query = VarianteProduit::with(['produit', 'taille']);

        if ($request->has('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        $variantes = $query->get();

        return response()->json($variantes);
    }

    // Détail d'une variante
    public function show($id)
    {
        $variante = VarianteProduit::with(['produit', 'taille'])->findOrFail($id);

        return response()->json($variante);
    }

    // Créer une variante (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produit_id' => 'required|exists:produits,id',
            'taille_id' => 'nullable|exists:tailles,id',
            'couleur' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:100|unique:variante_produits,sku',
            'prix_supplement' => 'nullable|numeric',
            'quantite_stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $variante = VarianteProduit::create($request->all());

        return response()->json($variante->load(['produit', 'taille']), 201);
    }

    // Modifier une variante (admin) — utile pour ajuster le stock
    public function update(Request $request, $id)
    {
        $variante = VarianteProduit::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'taille_id' => 'nullable|exists:tailles,id',
            'couleur' => 'nullable|string|max:50',
            'sku' => 'sometimes|string|max:100|unique:variante_produits,sku,' . $id,
            'prix_supplement' => 'nullable|numeric',
            'quantite_stock' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $variante->update($request->all());

        return response()->json($variante->load(['produit', 'taille']));
    }

    // Supprimer une variante (admin)
    public function destroy($id)
    {
        $variante = VarianteProduit::findOrFail($id);
        $variante->delete();

        return response()->json(['message' => 'Variante supprimée']);
    }
}
