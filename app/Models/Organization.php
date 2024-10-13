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
        'account_status_id',
    ];
    protected $with = ['account_status', 'delegates', /*'users','user', 'location', 'phone_numbers', 'admins', */ 'departments'];
    public function user()
    {
        return $this->belongsTo(User::class); //admin user
    }
    public function users()
    {
        return $this->hasMany(OrgUser::class); // all users of the organization 
    }
    public function category()
    {
        return $this->belongsTo(OrganizationCategory::class);
    }
    public function account_status()
    {
        return $this->belongsTo(UserAccountStatus::class);
    }
    public function delegates()
    {
        return $this->hasMany(OrgParent::class);
    }

    public function admins()
    {
        return $this->hasMany(User::class)->where('role_id', 2);
    }
    public function settings()
    {
        // return $this->hasOne();
        return null;
    }

    public function phone_numbers()
    {
        return $this->hasMany(OrganizationPhone::class);
    }
    public function location()
    {
        return $this->hasOne(OrganizationLocation::class);
    }
    public function departments()
    {
        return $this->hasMany(OrgDepartments::class);
    }
}
