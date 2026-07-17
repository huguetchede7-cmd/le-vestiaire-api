<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdresseController extends Controller
{
    // Liste des adresses du client connecté
    public function index()
    {
        $adresses = Adresse::where('user_id', Auth::guard('api')->id())->get();

        return response()->json($adresses);
    }

    public function show($id)
    {
        $adresse = Adresse::where('user_id', Auth::guard('api')->id())->findOrFail($id);

        return response()->json($adresse);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'nullable|string|max:100',
            'ville' => 'required|string|max:100',
            'quartier' => 'nullable|string|max:100',
            'indication' => 'nullable|string',
            'par_defaut' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $adresse = Adresse::create([
            ...$request->all(),
            'user_id' => Auth::guard('api')->id(),
        ]);

        return response()->json($adresse, 201);
    }

    public function update(Request $request, $id)
    {
        $adresse = Adresse::where('user_id', Auth::guard('api')->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'libelle' => 'nullable|string|max:100',
            'ville' => 'sometimes|string|max:100',
            'quartier' => 'nullable|string|max:100',
            'indication' => 'nullable|string',
            'par_defaut' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $adresse->update($request->all());

        return response()->json($adresse);
    }

    public function destroy($id)
    {
        $adresse = Adresse::where('user_id', Auth::guard('api')->id())->findOrFail($id);
        $adresse->delete();

        return response()->json(['message' => 'Adresse supprimée']);
    }
}
