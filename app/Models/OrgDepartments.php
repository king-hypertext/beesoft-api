<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgDepartments extends Model
{
    use HasFactory;
    protected $fillable = [
        'organization_id',
        'name',
        'description',
    ];
    // protected $with = ['organization'];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
