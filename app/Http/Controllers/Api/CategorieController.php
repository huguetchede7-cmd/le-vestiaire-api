<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    // Liste toutes les catégories (structure hiérarchique)
    public function index()
    {
        $categories = Categorie::with('enfants')
            ->whereNull('parent_id')
            ->get();

        return response()->json($categories);
    }

    // Détail d'une catégorie avec ses produits
    public function show($id)
    {
        $categorie = Categorie::with(['enfants', 'produits'])->findOrFail($id);

        return response()->json($categorie);
    }

    // Créer une catégorie (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:categories,id',
            'nom' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categorie = Categorie::create($request->all());

        return response()->json($categorie, 201);
    }

    // Modifier une catégorie (admin)
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:categories,id',
            'nom' => 'sometimes|string|max:100',
            'type' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categorie->update($request->all());

        return response()->json($categorie);
    }

    // Supprimer une catégorie (admin)
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return response()->json(['message' => 'Catégorie supprimée']);
    }
}
