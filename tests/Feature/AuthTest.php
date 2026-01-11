<?php

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('returns success on login page', function () {

    get(route('login'))
        ->assertStatus(200)
        ->assertSee('Login')
        ->assertSee('Forgot Password?')
        ->assertSee('Click here to create one')
        ->assertSeeInOrder([
            route('password.request'),
            route('signup'),
            route('login.oauth', 'google'),
            route('login.oauth', 'facebook'),
        ]);
});

it('should not be possible to login with incorrect credentials', function () {
    \App\Models\User::factory()->create([
        'email' => 'zura@example.com',
        'password' => bcrypt('password')
    ]);

    post(route('login.store'), [
        'email' => 'zura@example.com',
        'password' => '123456'
    ])->assertStatus(302)
        //        ->assertSessionHasErrors(['email'])
        ->assertInvalid(['email']);
});
