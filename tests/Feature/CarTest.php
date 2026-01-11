<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should not be possible to access car create page as guest user', function () {

    get(route('car.create'))
        ->assertRedirectToRoute('login')
        ->assertStatus(302);
});

it('should be possible to access car create page as authenticated user', function () {
    $user = \App\Models\User::factory()->create();

    actingAs($user)
        ->get(route('car.create'))
        ->assertOk()
        ->assertSee("Add new car");
});

it('should not be possible to access my cars page as guest user', function () {
    get(route('car.index'))
        ->assertRedirectToRoute('login');
});

it('should be possible to access my cars page as authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)
        ->get(route('car.index'))
        ->assertOk()
        ->assertSee("My Cars");
});
