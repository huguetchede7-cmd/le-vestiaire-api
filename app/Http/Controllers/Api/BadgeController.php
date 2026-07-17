<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BadgeController extends Controller
{
    public function index()
    {
        return response()->json(Badge::all());
    }

    public function show($id)
    {
        return response()->json(Badge::findOrFail($id));
    }

    // Créer un badge (admin) — ex: badge de champion, badge de compétition
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'image' => 'nullable|string|max:255',
            'prix' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $badge = Badge::create($request->all());

        return response()->json($badge, 201);
    }

    public function update(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:100',
            'image' => 'nullable|string|max:255',
            'prix' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $badge->update($request->all());

        return response()->json($badge);
    }

    public function destroy($id)
    {
        Badge::findOrFail($id)->delete();

        return response()->json(['message' => 'Badge supprimé']);
    }
}
