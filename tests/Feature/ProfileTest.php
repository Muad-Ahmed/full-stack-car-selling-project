<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should not be possible to access profile as guest user', function () {
    get(route('profile.index'))->assertRedirectToRoute('login');
});

it('should be possible to access profile as auth user', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get(route('profile.index'))->assertOk()
        ->assertSee('My Profile');
});
