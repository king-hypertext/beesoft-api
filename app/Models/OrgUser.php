<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgUser extends Model
{
    use HasFactory;
    protected $with = ['organization', 'card', 'org_parent'];
    protected $fillable = [
        'organization_id',
        'card_id',
        'full_name',
        'full_name',
        'email',
        'mum_phone',
        'dad_phone',
        'department_id',
        'gender',
        'parental_action',
        'voice',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function card()
    {
        return $this->hasOne(Card::class);
    }
    public function org_parent()
    {
        return $this->hasMany(OrgParent::class);
    }
}
