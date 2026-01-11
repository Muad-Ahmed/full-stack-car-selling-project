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

it('should be possible to login with correct credentials', function () {
    \App\Models\User::factory()->create([
        'email' => 'zura@example.com',
        'password' => bcrypt('password')
    ]);

    post(route('login.store'), [
        'email' => 'zura@example.com',
        'password' => 'password'
    ])->assertStatus(302)
        ->assertRedirectToRoute('home')
        ->assertSessionHas(['success']);
});

it('returns success on signup page', function () {
    get(route('signup'))
        ->assertStatus(200)
        ->assertSee('Signup')
        ->assertSee('Click here to login')
        ->assertSeeInOrder([
            route('login'),
            route('login.oauth', 'google'),
            route('login.oauth', 'facebook'),
        ]);
});

it('should not be possible to signup with empty', function () {

    post(route('signup.store'), [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
        'password_confirmation' => '',
    ])->assertStatus(302)
        ->assertInvalid(['name', 'email', 'phone', 'password']);
});

it('should not be possible to signup with incorrect password', function () {

    post(route('signup.store'), [
        'name' => 'Zura',
        'email' => 'zura@example.com',
        'phone' => '123',
        'password' => '123456',
        'password_confirmation' => '1111',
    ])->assertStatus(302)
        ->assertInvalid(['password']);
});

it('should not be possible to signup with existing email', function () {
    \App\Models\User::factory()->create([
        'email' => 'zura@example.com'
    ]);
    post(route('signup.store'), [
        'name' => 'Zura',
        'email' => 'zura@example.com',
        'phone' => '123',
        'password' => '1asda523Aa.#',
        'password_confirmation' => '1asda523Aa.#',
    ])->assertStatus(302)
        ->assertInvalid(['email']);
});

it('should be possible to signup with correct data', function () {
    post(route('signup.store'), [
        'name' => 'Zura',
        'email' => 'zura@example.com',
        'phone' => '123456',
        'password' => 'dajhdgaA12312@#',
        'password_confirmation' => 'dajhdgaA12312@#'
    ])->assertStatus(302)
        ->assertRedirectToRoute('home')
        ->assertSessionHas(['success'])
        ->assertDatabaseHas('users', ['email' => 'zura@example.com']);
});

it('returns success on forgot password page', function () {
    get(route('password.request'))
        ->assertStatus(200)
        ->assertSee('Request Password Reset')
        ->assertSee('Click here to login')
        ->assertSee(route('login'));
});

it('should not be possible to request password with incorrect email', function () {

    post(route('password.email'), [
        'email' => 'zura@example.com',
    ])->assertStatus(302)
        //        ->assertSessionHasErrors(['email'])
        ->assertInvalid(['email']);
});

it('should be possible to request password with correct email', function () {
    \App\Models\User::factory()->create([
        'email' => 'zura@example.com',
        'password' => bcrypt('123456')
    ]);

    post(route('password.email'), [
        'email' => 'zura@example.com',
    ])->assertStatus(302)
        ->assertSessionHas(['success']);
});
