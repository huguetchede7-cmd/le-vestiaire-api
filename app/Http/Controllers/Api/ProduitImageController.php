<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProduitImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProduitImageController extends Controller
{
    // Liste des images d'un produit
    public function index($produitId)
    {
        $images = ProduitImage::where('produit_id', $produitId)
            ->orderBy('ordre')
            ->get();

        return response()->json($images);
    }

    // Ajouter une image (fichier upload OU url)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produit_id' => 'required|exists:produits,id',
            'fichier' => 'nullable|image|max:5120',
            'url' => 'nullable|string|url',
            'ordre' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$request->hasFile('fichier') && !$request->filled('url')) {
            return response()->json(['message' => 'Fournir un fichier ou une url.'], 422);
        }

        $url = $request->input('url');

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('produits', 'public');
            $url = Storage::url($path);
        }

        $image = ProduitImage::create([
            'produit_id' => $request->produit_id,
            'url' => $url,
            'ordre' => $request->ordre ?? 0,
        ]);

        return response()->json($image, 201);
    }

    // Supprimer une image
    public function destroy($id)
    {
        $image = ProduitImage::findOrFail($id);

        // Si l'image est stockee localement (pas une url externe), on la supprime du disque
        if (str_starts_with($image->url, '/storage/')) {
            $path = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($path);
        }

        $image->delete();

        return response()->json(['message' => 'Image supprimee']);
    }
}