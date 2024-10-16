<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone_number',
        'image',
        'account_status_id',
        'role_id',
    ];
    protected $with = ['account_status', 'organization', 'role'];
    public function hasRole(string $role)
    {
        return $this->role->role === $role;
    }
    public function isSuperAdmin(): bool|null
    {
        return $this->role->role === 'super_admin' ? true : false;
    }
    public function isAdmin(): bool|null
    {
        return $this->role->role === 'admin' ? true : false;
    }
    public function isParent(): bool|null
    {
        return $this->role->role === 'parent' ? true : false;
    }
    public function isSecurity(): bool|null
    {
        return $this->role->role === 'security' ? true : false;
    }
    public function isSecretary(): bool|null
    {
        return $this->role->role === 'secretary' ? true : false;
    }
    public function otc(): HasOne
    {
        return $this->hasOne(OTC::class);
    }
    public function user_settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }
    public function organization()
    {
        return $this->hasOne(Organization::class);
    }
    public function org_parent()
    {
        return $this->hasMany(OrgParent::class);
    }
    public function orgUsers(){
        return $this->hasMany(OrgUser::class);
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }
    public function account_status(): BelongsTo
    {
        return $this->belongsTo(UserAccountStatus::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
