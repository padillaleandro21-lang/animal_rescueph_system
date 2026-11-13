<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdoptionMonitoring;
class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'animal_id',

        'first_name',
        'last_name',
        'email',
        'contact_number',

        'occupation',
        'civil_status',

        'house_street',
        'region',
        'province',
        'city_municipality',
        'barangay',
        'zip_code',

        'reason_for_adoption',
        'reason_explanation',
        'archived_at',
         'rejection_reason',
        'primary_responsible',
        'primary_responsible_other',

        'residence_type',
        'residence_other',

        'landlord_permission',

        'household_members',
        'household_support',

        'commitment_food_shelter_care',
        'commitment_veterinary_care',
        'commitment_safety',
        'commitment_policies',
        'commitment_post_adoption',

        'valid_id_path',
        'valid_id_original_name',
        'id_verification_status',

        'status',
        'admin_notes',

        'agreement_information',
        'agreement_not_automatic',
        'agreement_policies',

        'submitted_at',
    ];

    protected $casts = [

        'commitment_food_shelter_care' => 'boolean',
        'commitment_veterinary_care' => 'boolean',
        'commitment_safety' => 'boolean',
        'commitment_policies' => 'boolean',
        'commitment_post_adoption' => 'boolean',
         'archived_at'   => 'datetime',
        'agreement_information' => 'boolean',
        'agreement_not_automatic' => 'boolean',
        'agreement_policies' => 'boolean',

        'submitted_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | ANIMAL
    |--------------------------------------------------------------------------
    */

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
    public function monitorings()
{
    return $this->hasMany(
        AdoptionMonitoring::class,
        'adoption_application_id'
    );
}
}