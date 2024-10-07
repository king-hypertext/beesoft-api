<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationLocation extends Model
{
    use HasFactory;
    protected $with = ['city', 'district'];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function city()
    {
        return $this->hasOne(City::class);
    }
    public function district()
    {
        return $this->hasOne(District::class);
    }
}
