<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgParent extends Model
{
    use HasFactory;
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function children()
    {
        return $this->hasMany(Children::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function delegates()
    {
        return $this->hasMany(ParentDelegate::class);
    }
    public function org_user()
    {
        return $this->belongsTo(OrgUser::class);
    }
}
