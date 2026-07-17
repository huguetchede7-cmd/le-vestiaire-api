<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    // Liste des produits avec filtres optionnels
    public function index(Request $request)
    {
        $query = Produit::with(['typeProduit', 'categories', 'images', 'variantes.taille'])
            ->where('actif', true);

        if ($request->has('categorie_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->categorie_id);
            });
        }

        if ($request->has('prix_min')) {
            $query->where('prix_base', '>=', $request->prix_min);
        }

        if ($request->has('prix_max')) {
            $query->where('prix_base', '<=', $request->prix_max);
        }

        if ($request->has('recherche')) {
            $query->where('nom', 'like', '%' . $request->recherche . '%');
        }

        $produits = $query->paginate(20);

        return response()->json($produits);
    }

    // Détail d'un produit
    public function show($id)
    {
        $produit = Produit::with(['typeProduit', 'categories', 'images', 'variantes.taille', 'avis.user'])
            ->findOrFail($id);

        return response()->json($produit);
    }

    // Créer un produit (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_produit_id' => 'required|exists:type_produits,id',
            'nom' => 'required|string|max:150',
            'marque' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'prix_base' => 'required|numeric|min:0',
            'actif' => 'boolean',
            'categorie_ids' => 'nullable|array',
            'categorie_ids.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produit = Produit::create($request->only([
            'type_produit_id', 'nom', 'marque', 'description', 'prix_base', 'actif',
        ]));

        if ($request->has('categorie_ids')) {
            $produit->categories()->sync($request->categorie_ids);
        }

        return response()->json($produit->load(['typeProduit', 'categories']), 201);
    }

    // Modifier un produit (admin)
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type_produit_id' => 'sometimes|exists:type_produits,id',
            'nom' => 'sometimes|string|max:150',
            'marque' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'prix_base' => 'sometimes|numeric|min:0',
            'actif' => 'boolean',
            'categorie_ids' => 'nullable|array',
            'categorie_ids.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produit->update($request->only([
            'type_produit_id', 'nom', 'marque', 'description', 'prix_base', 'actif',
        ]));

        if ($request->has('categorie_ids')) {
            $produit->categories()->sync($request->categorie_ids);
        }

        return response()->json($produit->load(['typeProduit', 'categories']));
    }

    // Supprimer un produit (admin)
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return response()->json(['message' => 'Produit supprimé']);
    }
}
