<?php

namespace App\Http\Controllers;

use App\Models\favoris;
use App\Models\Itineraire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function addTofavoris(Request $request, $id)
    {
        $itineraire = Itineraire::find($id);
        
        if (!$itineraire) {
            return response()->json(['ok' => false, 'message' => 'Itineraire not found'], 404);
        }
    
        $existingFavoris = Favoris::where('userId', Auth::id())
                                ->where('itineraireId', $id)
                                ->first();
    
        if ($existingFavoris) {
            return response()->json(['ok' => false, 'message' => 'Already added to favoris'], 409);
        }
    
        // Add itineraire to favoris
        $favoris = Favoris::create([
            'userId' => Auth::id(),
            'itineraireId' => $id,
        ]);
    
        return response()->json(['ok' => true, 'favoris' => $favoris], 201);
    }
    
}
