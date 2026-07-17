<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flocage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlocageController extends Controller
{
    // Liste des options de flocage existantes (pour l'admin ou historique)
    public function index()
    {
        return response()->json(Flocage::all());
    }

    public function show($id)
    {
        return response()->json(Flocage::findOrFail($id));
    }

    // Créer un flocage — utilisé quand le client personnalise son maillot
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_joueur' => 'nullable|string|max:50',
            'numero' => 'nullable|string|max:5',
            'style_ecriture' => 'nullable|string|max:50',
            'couleur' => 'nullable|string|max:30',
            'prix_supplement' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $flocage = Flocage::create($request->all());

        return response()->json($flocage, 201);
    }

    public function update(Request $request, $id)
    {
        $flocage = Flocage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nom_joueur' => 'nullable|string|max:50',
            'numero' => 'nullable|string|max:5',
            'style_ecriture' => 'nullable|string|max:50',
            'couleur' => 'nullable|string|max:30',
            'prix_supplement' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $flocage->update($request->all());

        return response()->json($flocage);
    }

    public function destroy($id)
    {
        Flocage::findOrFail($id)->delete();

        return response()->json(['message' => 'Flocage supprimé']);
    }
}
