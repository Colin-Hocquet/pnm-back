<?php
it(' user unauthenticated  cannot get vehicle', function () {
    $response = $this->get('api/vehicle');
    $response->assertStatus(401);
});

it('user authenticated  can get vehicle', function () {
    // ActingAs permet de simuler le fait d'être un utilisateur
    $response = $this->actingAs(\App\Models\User::factory()->create())
    ->get('api/vehicle');
    $response->assertStatus(200);
});