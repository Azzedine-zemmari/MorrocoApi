<?php

namespace Tests\Feature; 

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class InsertDestinationTest extends TestCase 
{ 

    public function test_insert_destination(): void 
    {
        $user = User::where('email','TTTTT@gmail.com')->first();
        $this->actingAs($user);
        

        $response = $this->postJson('/api/destination/add', [
            "titre" => "voyage au tanger",
            "categorie" => "action",
            "duree" => 8,
            "image" => "sahara.jpg",
            "destinations" => [
                [ 
                    "nom" => "Laayoune",
                    "lounge" => "Hôtel Laayoune",
                    "places_to_visit" => [
                        "Plage Foum el Oued",
                        "Centre ville"
                    ]
                ]
            ]
        ]);

        $response->assertStatus(201);
    }
}
