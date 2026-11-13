<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AdoptionApplication;
class Animal extends Model
{
    protected $fillable = [

        'name',
        'animal_type',
        'breed',
        'age',
        'gender',
        'weight',
        'height',
        'animal_image',

        'source_type',
        'report_id',
        'date_acquired',
        'location_found',

        'health_condition',
        'medical_notes',

        'vaccinations',

        'status',

        'cage_id',

        'additional_notes',
    ];

    protected $casts = [
        'date_acquired' => 'date',
        'vaccinations' => 'array',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RESCUE REPORT
    |--------------------------------------------------------------------------
    */

    public function report(): BelongsTo
    {
        return $this->belongsTo(
            AnimalReport::class,
            'report_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CAGE
    |--------------------------------------------------------------------------
    */

    public function cage(): BelongsTo
    {
        return $this->belongsTo(
            Cage::class,
            'cage_id'
        );
    }
   
    public function adoptionApplications()
{
    return $this->hasMany(
        AdoptionApplication::class
    );
}
 
}
