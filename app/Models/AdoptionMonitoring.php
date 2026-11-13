<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'adoption_application_id',
        'week_number',
        'monitoring_date',
        'animal_condition',
        'food_water',
        'shelter_condition',
        'care_compliance',
        'notes',
        'status',
    ];

    protected $casts = [
        'monitoring_date' => 'date',
        'animal_condition' => 'boolean',
        'food_water' => 'boolean',
        'shelter_condition' => 'boolean',
        'care_compliance' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(
            AdoptionApplication::class,
            'adoption_application_id'
        );
    }
}