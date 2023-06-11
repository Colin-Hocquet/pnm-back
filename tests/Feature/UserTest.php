<?php
it('unauthenticated user cannot get userDetail', function () {
    $response = $this->get('api/user/1');
    $response->assertStatus(401);
});

it('user authenticated  can get userDetail', function () {
    // ActingAs permet de simuler le fait d'être un utilisateur
    $response = $this->actingAs(\App\Models\User::factory()->create())
    ->get('api/user/1');
    $response->assertStatus(200);
});