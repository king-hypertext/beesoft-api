<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $with = ['delegates', 'card',  'department', 'organization'];
    protected $withCount = ['delegates'];
    protected $fillable = [
        'organization_id',
        'department_id',
        'full_name',
        'date_of_birth',
        'email',
        'mum_phone',
        'dad_phone',
        'gender',
        'parental_action',
        'voice',
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function department()
    {
        return $this->belongsTo(OrgDepartments::class);
    }
    public function card()
    {
        return $this->hasOne(Card::class);
    }
    public function delegates()
    {
        return $this->hasMany(OrgParent::class);
    }
    // public function parent_delegates()
    // {
    //     return $this->hasMany(OrgParent::class)->where('org_user_id', $this->id);
    // }
}
