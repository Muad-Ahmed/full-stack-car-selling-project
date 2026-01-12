<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\seed;

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

it('should not create car with empty data', function () {
    seed();
    $user = \App\Models\User::factory()->create();

    actingAs($user)->post(route('car.store'), [
        'maker_id' => null,
        'model_id' => null,
        'year' => null,
        'price' => null,
        'vin' => null,
        'mileage' => null,
        'car_type_id' => null,
        'fuel_type_id' => null,
        'state_id' => null,
        'city_id' => null,
        'address' => null,
        'phone' => null,
        'description' => null,
        'published_at' => null,
    ])->assertInvalid([
        'maker_id',
        'model_id',
        'year',
        'price',
        'vin',
        'mileage',
        'car_type_id',
        'fuel_type_id',
        'state_id',
        'city_id',
        'address',
        'phone',
    ]);
});

it('should not create car with invalid data', function () {
    seed();
    $user = \App\Models\User::factory()->create();

    actingAs($user)->post(route('car.store'), [
        'maker_id' => 100,
        'model_id' => 100,
        'year' => 1800,
        'price' => -1000,
        'vin' => '123',
        'mileage' => -1000,
        'car_type_id' => 100,
        'fuel_type_id' => 100,
        'state_id' => 100,
        'city_id' => 100,
        'address' => '123',
        'phone' => '123',
    ])->assertInvalid([
        'maker_id',
        'model_id',
        'year',
        'price',
        'vin',
        'mileage',
        'car_type_id',
        'fuel_type_id',
        'state_id',
        'city_id',
        'phone',
    ]);
});

it('should create car with valid data', function () {
    seed();
    $countCars = \App\Models\Car::count();
    $countImages = \App\Models\CarImage::count();
    $user = \App\Models\User::factory()->create();

    $images = [
        UploadedFile::fake()->image('1.jpg'),
        UploadedFile::fake()->image('2.jpg'),
        UploadedFile::fake()->image('3.jpg'),
        UploadedFile::fake()->image('4.jpg'),
        UploadedFile::fake()->image('5.jpg'),
    ];

    $features = [
        'abs' => '1',
        'air_conditioning' => '1',
        'power_windows' => '1',
        'power_door_locks' => '1',
        'cruise_control' => '1',
        'bluetooth_connectivity' => '1',
    ];
    $carData = [
        'maker_id' => 1,
        'model_id' => 1,
        'year' => 2020,
        'price' => 10000,
        'vin' => '11111111111111111',
        'mileage' => 10000,
        'car_type_id' => 1,
        'fuel_type_id' => 1,
        'state_id' => 1,
        'city_id' => 1,
        'address' => '123',
        'phone' => '123456789',
        'features' => $features,
        'images' => $images
    ];

    actingAs($user)->post(route('car.store'), $carData)
        ->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $lastCar = \App\Models\Car::latest('id')->first();
    $features['car_id'] = $lastCar->id;

    $carData['id'] = $lastCar->id;
    unset($carData['features']);
    unset($carData['images']);
    unset($carData['state_id']);

    $this->assertDatabaseCount('cars', $countCars + 1);
    $this->assertDatabaseCount('car_images', $countImages + count($images));
    $this->assertDatabaseCount('car_features', $countCars + 1);
    $this->assertDatabaseHas('cars', $carData);
    $this->assertDatabaseHas('car_features', $features);
});


it('should display update car page with correct data', function () {
    seed();
    $user = \App\Models\User::first();
    $firstCar = $user->cars()->first();

    actingAs($user)
        ->get(route('car.edit', $firstCar->id))
        ->assertSee("Edit Car:")
        ->assertSeeInOrder([
            '<select id="makerSelect" name="maker_id">',
            '<option value="' . $firstCar->maker_id . '"',
            'selected>' . $firstCar->maker->name . '</option>'
        ], false)
        ->assertSeeInOrder([
            '<select id="modelSelect" name="model_id">',
            '<option value="' . $firstCar->model_id . '"',
            'selected>',
            $firstCar->model->name
        ], false)
        ->assertSeeInOrder([
            '<select name="year">',
            '<option value="' . $firstCar->year . '"',
            'selected>' . $firstCar->year . '</option>',
        ], false)
        ->assertSeeInOrder([
            '<input type="radio" name="car_type_id" value="' . $firstCar->car_type_id . '"',
            'checked/>',
            $firstCar->carType->name,
        ], false)
        ->assertSeeInOrder([
            'name="price"',
            ' value="' . $firstCar->price . '"',
        ], false)
        ->assertSeeInOrder([
            'name="vin"',
            ' value="' . $firstCar->vin . '"',
        ], false)
        ->assertSeeInOrder([
            'name="mileage"',
            ' value="' . $firstCar->mileage . '"',
        ], false)
        ->assertSeeInOrder([
            '<input type="radio" name="fuel_type_id" value="' . $firstCar->fuel_type_id . '"',
            'checked/>',
            $firstCar->fuelType->name,
        ], false)
        ->assertSeeInOrder([
            '<select id="stateSelect" name="state_id">',
            '<option value="' . $firstCar->city->state_id . '"',
            'selected>',
            $firstCar->city->state->name
        ], false)
        ->assertSeeInOrder([
            '<select id="citySelect" name="city_id">',
            '<option value="' . $firstCar->city_id . '"',
            'selected>',
            $firstCar->city->name
        ], false)
        ->assertSeeInOrder([
            'name="address"',
            ' value="' . $firstCar->address . '"',
        ], false)
        ->assertSeeInOrder([
            'name="phone"',
            ' value="' . $firstCar->phone . '"',
        ], false)
        ->assertSeeInOrder([
            '<textarea',
            'name="description"',
            $firstCar->description . '</textarea>',
        ], false)
        ->assertSeeInOrder([
            'name="published_at"',
            ' value="' . (new Carbon($firstCar->published_at))->format('Y-m-d') . '"',
        ], false);
});

it('should successfully update the car details', function () {
    seed();
    $countCars = \App\Models\Car::count();
    $user = User::first();
    $firstCar = $user->cars()->first();

    $features = [
        'abs' => '1',
        'air_conditioning' => '1',
        'power_windows' => '1',
        'power_door_locks' => '1',
        'cruise_control' => '1',
        'bluetooth_connectivity' => '1',
    ];
    $carData = [
        'maker_id' => 1,
        'model_id' => 1,
        'year' => 2020,
        'price' => 10000,
        'vin' => '11111111111111111',
        'mileage' => 10000,
        'car_type_id' => 1,
        'fuel_type_id' => 1,
        'state_id' => 1,
        'city_id' => 1,
        'address' => '123',
        'phone' => '123456789',
        'features' => $features,
    ];

    $this->actingAs($user)
        ->put(route('car.update', $firstCar), $carData)
        ->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $carData['id'] = $firstCar->id;
    $features['car_id'] = $firstCar->id;
    unset($carData['features']);
    unset($carData['images']);
    unset($carData['state_id']);

    $this->assertDatabaseCount('cars', $countCars);
    $this->assertDatabaseHas('cars', $carData);
    $this->assertDatabaseCount('car_features', $countCars);
    $this->assertDatabaseHas('car_features', $features);
});

it('should successfully delete a car', function () {
    seed();

    $countCars = \App\Models\Car::count();
    $user = User::first();
    $firstCar = $user->cars()->first();

    $this->actingAs($user)
        ->delete(route('car.destroy', $firstCar))
        ->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $this->assertSoftDeleted($firstCar);
});
