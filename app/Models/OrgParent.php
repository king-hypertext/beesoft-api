<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgParent extends Model
{
    use HasFactory;
    protected $table = 'org_user_delegates';
    protected $fillable = [
        // 'user_id',
        'organization_id',
        'org_user_id',
        'address',
        'phone_number',
        'account_status'
    ];
    // protected $with = ['orgUser', 'organization'];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function wards()
    {
        return $this->belongsTo(OrgUser::class,  'org_user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// return $this->hasMany(OrgUser::class)->where('mum_phone', $this->user->phone_number)->orWhere('dad_phone', $this->user->phone_number);