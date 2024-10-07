<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentDelegate extends Model
{
    use HasFactory;
    public function org_parent()
    {
        return $this->belongsTo(OrgParent::class);
    }
    public function children()
    {
        return $this->hasMany(Children::class);
    }
}
