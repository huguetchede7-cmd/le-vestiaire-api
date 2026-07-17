<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emballage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmballageController extends Controller
{
    public function index()
    {
        return response()->json(Emballage::all());
    }

    public function show($id)
    {
        return response()->json(Emballage::findOrFail($id));
    }

    // Créer un type d'emballage (admin) — ex: "Cadeau", "Standard"
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:50',
            'message_personnalise' => 'nullable|string',
            'prix' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $emballage = Emballage::create($request->all());

        return response()->json($emballage, 201);
    }

    public function update(Request $request, $id)
    {
        $emballage = Emballage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|string|max:50',
            'message_personnalise' => 'nullable|string',
            'prix' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $emballage->update($request->all());

        return response()->json($emballage);
    }

    public function destroy($id)
    {
        Emballage::findOrFail($id)->delete();

        return response()->json(['message' => 'Emballage supprimé']);
    }
}
