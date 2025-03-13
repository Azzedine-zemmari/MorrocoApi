<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itineraire;
use Illuminate\Support\Facades\Auth;

class ItineraireController extends Controller
{

    public function update(Request $request, $id)
    {
        // Find the itinerary belonging to the authenticated user
        $itineraire = Itineraire::where('id', $id)
            ->where('userId', Auth::id())
            ->first();
    
        if (!$itineraire) {
            return response()->json(["ok" => false, "message" => "Itineraire not found"], 404);
        }
    
        // Validate request data
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string',
            'duree' => 'required|integer|min:1',
            'image' => 'nullable|string',
            'destinations' => 'nullable|array|min:1',
            'destinations.*.nom' => 'required|string|max:255',
            'destinations.*.lounge' => 'nullable|string|max:255',
            'destinations.*.places_to_visit' => 'nullable|array',
        ]);
    
        // Update the main itinerary fields
        $itineraire->update([
            'titre' => $validated['titre'],
            'categorie' => $validated['categorie'],
            'duree' => $validated['duree'],
            'image' => $validated['image'] ?? $itineraire->image,
        ]);
    
        // Update destinations if provided
        if (isset($validated['destinations'])) {
            $itineraire->destinations()->delete(); // Remove old destinations
            foreach ($validated['destinations'] as $destinationData) {
                $itineraire->destinations()->create($destinationData);
            }
        }
    
        return response()->json([
            'ok' => true,
            'message' => 'Itineraire updated successfully',
            'data' => $itineraire->load('destinations')
        ], 200);
    }
    
    public function addDestinations(Request $request, $id)
    {
        $itineraire = Itineraire::find($id);
        if (!$itineraire) {
            return response()->json(['ok' => false, 'message' => 'Itineraire not found'], 404);
        }
        $validated = $request->validate([
            'destinations' => 'required|array|min:1',
            'destinations.*.nom' => 'required|string|max:255',
            'destinations.*.lounge' => 'nullable|string|max:255',
            'destinations.*.places_to_visit' => 'nullable|array',
        ]);
        // Attach new destinations to the itinerary
        foreach ($validated['destinations'] as $destinationData) {
            $itineraire->destinations()->create($destinationData);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Destinations added successfully',
            'itineraire' => $itineraire->load('destinations') // Eager load destinations
        ], 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string',
            'duree' => 'required|integer|min:1',
            'image' => 'nullable|string',
            'destinations' => 'required|array',
            'destinations.*.nom' => 'required|string',
            'destinations.*.lounge' => 'nullable|string',
            'destinations.*.places_to_visit' => 'nullable|array',
        ]);

        // Create the itinerary
        $itinerary = Auth::user()->itineraries()->create($validated);

        // Attach destinations to the itinerary
        foreach ($validated['destinations'] as $destinationData) {
            $itinerary->destinations()->create($destinationData);
        }

        return response()->json([
            'message' => 'Success',
            'itinerary' => $itinerary
        ], 201);
    }
}
