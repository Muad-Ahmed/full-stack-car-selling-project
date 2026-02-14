<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'image_path',
        'position',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function getUrl()
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        // If path starts with a leading slash we assume it's a public path
        // (for example: /images/cars/car_main_1.jpg) and return it directly.
        if (str_starts_with($this->image_path, '/')) {
            return $this->image_path;
        }

        return Storage::disk('public')->url(
            Str::after($this->image_path, 'public/')
        );
    }
}
