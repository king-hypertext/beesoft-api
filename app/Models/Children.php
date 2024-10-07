<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function delegate()
    {
        return $this->belongsTo(OrgParent::class);
    }
}
