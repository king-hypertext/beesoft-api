<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationCategory extends Model
{
    use HasFactory;
    protected $table ='org_categories';
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
