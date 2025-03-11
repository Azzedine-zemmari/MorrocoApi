<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itineraire;
use Illuminate\Support\Facades\Auth;

class ItineraireController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'titre' => 'required|string|max:50',
            'categorie' => 'required|string|max:100',
            'duree' => 'required|date_format:Y-m-d', 
            'image' => 'required|string|max:255',
            'destinations'=>'required|array|min:2'
        ]);

        $itineraire = Itineraire::create([
            'titre' => $validate['titre'],
            'categorie' => $validate['categorie'],
            'duree' => $validate['duree'],
            'image' => $validate['image'],
            'destinations' => $validate['destinations'],
            'userId' => Auth::id()
        ]);
        return response()->json(['ok'=>true,'it'=>$itineraire],201);
    }
    public function update(Request $request, $id)
    {
        $itineraire = Itineraire::where('id', $id)
        ->where('userId', Auth::id()) 
        ->first();
        
        if (!$itineraire) {
            return response()->json(["ok" => false, "message" => "Itineraire not found"], 404);
        }
        if ($itineraire) {
            $itineraire->update([
                'titre' => $request->titre,
                'categorie' => $request->categorie,
                'duree' => $request->duree,
                'image' => $request->image,
                'destinations' => $request->destinations
            ]);
            return response()->json(['ok' => true, 'data' => $itineraire], 201);
        } else {
            return response()->json(["ok" => false], 500);
        }
    }
}
