<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationLocation extends Model
{
    use HasFactory;
    protected $table = 'org_location';
    protected $fillable = [
        'organization_id',
        'city_id',
        'district_id',
        'community',
        'address',
        'latitude',
        'longitude',
        'is_active'  // Add a new field 'is_active' to indicate if the location is active or not. Default value should be 1 (active).
    ];
    protected $with = ['city', 'district'];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
