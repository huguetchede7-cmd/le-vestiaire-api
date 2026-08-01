<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Liste de tous les clients (admin uniquement)
    public function index()
    {
        if (Auth::guard('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Acces reserve aux administrateurs.'], 403);
        }

        $users = User::withCount('commandes')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($users);
    }

    // Detail d'un client avec ses commandes
    public function show($id)
    {
        if (Auth::guard('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Acces reserve aux administrateurs.'], 403);
        }

        $user = User::with(['commandes.lignes.varianteProduit.produit', 'adresses'])
            ->findOrFail($id);

        return response()->json($user);
    }
}