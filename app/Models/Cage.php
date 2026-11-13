<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cage extends Model
{
    protected $fillable = [
        'cage_number',
        'animal_type',
        'capacity',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | ANIMALS INSIDE THIS CAGE
    |--------------------------------------------------------------------------
    */

    public function animals(): HasMany
    {
        return $this->hasMany(
            Animal::class,
            'cage_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OCCUPIED SLOTS
    |--------------------------------------------------------------------------
    */

    public function getOccupiedSlotsAttribute()
    {
        return $this->animals()->count();
    }


    /*
    |--------------------------------------------------------------------------
    | AVAILABLE SLOTS
    |--------------------------------------------------------------------------
    */

    public function getAvailableSlotsAttribute()
    {
        return max(
            $this->capacity - $this->occupied_slots,
            0
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    public function getDisplayStatusAttribute()
    {
        /*
        | Maintenance always has priority.
        */

        if (($this->status ?? 'Available') === 'Maintenance') {
            return 'Maintenance';
        }


        if ($this->occupied_slots >= $this->capacity) {
            return 'Full';
        }


        if ($this->occupied_slots > 0) {
            return 'Partially Filled';
        }


        return 'Available';
    }
}