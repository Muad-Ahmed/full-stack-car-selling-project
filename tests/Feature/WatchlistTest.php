<?php

use function Pest\Laravel\get;

it('should not be possible to access my favourite cars page as guest user', function () {
    get(route('watchlist.index'))->assertRedirectToRoute('login');
});

it('should be possible to access my favourite cars page as authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)
    ->get(route('watchlist.index'))
    ->assertOk()
    ->assertSee("My Favourite Cars");
});
