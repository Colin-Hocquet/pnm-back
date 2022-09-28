<?php
it('unauthenticated user cannot get list box', function () {
    $response = $this->get('api/box/all-by-user/1');
    $response->assertStatus(401);
});

it('user authenticated  can get list box', function () {
    // ActingAs permet de simuler le fait d'être un utilisateur
    $response = $this->actingAs(\App\Models\User::factory()->create())
    ->get('api/box/all-by-user/1');
    $response->assertStatus(200);
});