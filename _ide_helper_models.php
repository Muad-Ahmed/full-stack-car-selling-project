<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $maker_id
 * @property int $model_id
 * @property int $year
 * @property int $price
 * @property string $vin
 * @property int $mileage
 * @property int $car_type_id
 * @property int $fuel_type_id
 * @property int $user_id
 * @property int $city_id
 * @property string $address
 * @property string $phone
 * @property string|null $description
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\CarType $carType
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $favouredUsers
 * @property-read int|null $favoured_users_count
 * @property-read \App\Models\CarFeatures|null $features
 * @property-read \App\Models\FuelType $fuelType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CarImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Maker $maker
 * @property-read \App\Models\Model $model
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\CarImage|null $primaryImage
 * @method static \Database\Factories\CarFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCarTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereFuelTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car withoutTrashed()
 */
	class Car extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $car_id
 * @property int $abs
 * @property int $air_conditioning
 * @property int $power_windows
 * @property int $power_door_locks
 * @property int $cruise_control
 * @property int $bluetooth_connectivity
 * @property int $remote_start
 * @property int $gps_navigation
 * @property int $heated_seats
 * @property int $climate_control
 * @property int $rear_parking_sensors
 * @property int $leather_seats
 * @property-read \App\Models\Car|null $car
 * @method static \Database\Factories\CarFeaturesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereAbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereAirConditioning($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereBluetoothConnectivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereClimateControl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereCruiseControl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereGpsNavigation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereHeatedSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereLeatherSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures wherePowerDoorLocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures wherePowerWindows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereRearParkingSensors($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarFeatures whereRemoteStart($value)
 */
	class CarFeatures extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $car_id
 * @property string $image_path
 * @property int $position
 * @property-read \App\Models\Car $car
 * @method static \Database\Factories\CarImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarImage wherePosition($value)
 */
	class CarImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @method static \Database\Factories\CarTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarType whereName($value)
 */
	class CarType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @property-read \App\Models\State $state
 * @method static \Database\Factories\CityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereStateId($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @method static \Database\Factories\FuelTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FuelType whereName($value)
 */
	class FuelType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Model> $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\MakerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maker query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Maker whereName($value)
 */
	class Maker extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $maker_id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @property-read \App\Models\Maker $maker
 * @method static \Database\Factories\ModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereMakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereName($value)
 */
	class Model extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\City> $cities
 * @property-read int|null $cities_count
 * @method static \Database\Factories\StateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereName($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $google_id
 * @property string|null $facebook_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $favouriteCars
 * @property-read int|null $favourite_cars_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

