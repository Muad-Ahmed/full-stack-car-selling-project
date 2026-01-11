<?php

use function Pest\Laravel\get;
use function Pest\Laravel\seed;

it('should display "there are no published cars" on home', function () {
    get('/')
        ->assertStatus(200)
        ->assertSee("There are no published cars.");
});

it('should display published cars on the home page', function () {
    seed();

    get('/')
        ->assertStatus(200)
        ->assertDontSee("There are no published cars.")
        ->assertViewHas('cars', fn($collection) => $collection->count() == 30);
});
