<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Taille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TailleController extends Controller
{
    // Liste toutes les tailles, triées par ordre
    public function index()
    {
        $tailles = Taille::orderBy('ordre')->get();

        return response()->json($tailles);
    }

    // Détail d'une taille
    public function show($id)
    {
        $taille = Taille::findOrFail($id);

        return response()->json($taille);
    }

    // Créer une taille (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'required|string|max:20',
            'type_taille' => 'required|string|max:20',
            'ordre' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $taille = Taille::create($request->all());

        return response()->json($taille, 201);
    }

    // Modifier une taille (admin)
    public function update(Request $request, $id)
    {
        $taille = Taille::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'libelle' => 'sometimes|string|max:20',
            'type_taille' => 'sometimes|string|max:20',
            'ordre' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $taille->update($request->all());

        return response()->json($taille);
    }

    // Supprimer une taille (admin)
    public function destroy($id)
    {
        $taille = Taille::findOrFail($id);
        $taille->delete();

        return response()->json(['message' => 'Taille supprimée']);
    }
}
