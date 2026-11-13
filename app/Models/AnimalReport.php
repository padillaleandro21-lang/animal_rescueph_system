<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalReport extends Model
{
    protected $table = 'animal_reports';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',

        'region',
        'province',
        'city_municipality',
        'barangay',
        'house_street',

        'latitude',
        'longitude',

        'animal_image',
        'animal_type',
        'breed',
        'confidence',

        'additional_notes',

        'status',
         'archived_at',
         'rejection_reason',
    ];

    protected $casts = [
        'confidence' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
        'archived_at' => 'datetime',
    ];
}