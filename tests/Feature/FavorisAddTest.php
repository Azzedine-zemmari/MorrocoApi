<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FavorisAddTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_Favoris(): void
    {
        $user = User::where('email','TTTTT@gmail.com')->first();
        $this->actingAs($user);

        $response = $this->postJson('/favoris/add/2');

        $response->assertStatus(201);
    }
}
