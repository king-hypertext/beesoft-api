<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'post_office_address',
        'image',
        'user_id',
        'category_id',
        'email',
        'activated_by',
        'sms_api_key',
        'sms_api_secret_key',
        'sms_provider',
        'manage_clock_in',
        'signature_clock_in',
        'account_status',
        ''
    ];
    protected $with = ['account_status', 'children', 'members', 'org_parent', 'user', 'location', 'phone_numbers'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function org_parent()
    {
        return $this->hasMany(OrgParent::class);
    }
    public function children()
    {
        return $this->hasMany(Children::class);
    }
    public function members()
    {
        return $this->hasMany(OrgMember::class);
    }
    public function settings()
    {
        // return $this->hasOne();
        return null;
    }
    public function category()
    {
        return $this->hasOne(OrganizationCategory::class);
    }
    public function phone_numbers()
    {
        return $this->hasMany(OrganizationPhone::class);
    }
    public function location()
    {
        return $this->hasOne(OrganizationLocation::class);
    }
    public function account_status()
    {
        return $this->belongsTo(UserAccountStatus::class);
    }
    public function org_users()
    {
        return $this->hasMany(OrgUser::class);
    }
}
