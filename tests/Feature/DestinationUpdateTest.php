<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class DestinationUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_update_destination(): void
    {
        $user = User::where('email','TTTTT@gmail.com')->first();
        $this->actingAs($user);

        $response = $this->putJson('/api/destination/update/1', [
                "titre"=>"RiHLAAAAA",
                "categorie"=>"rihlaNadia2",
                "duree"=>10,
                "image"=>"tswira.png",
                "destinations"=>[[
                    "nom"=> "sid bibi",
                    "lounge" =>"Hôtel bibi",
                    "places_to_visit"=> ["Place Hassan", "Plage"]
                ]
                ]
        ]);

        $response->assertStatus(200);

    }
}
