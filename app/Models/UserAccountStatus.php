<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAccountStatus extends Model
{
    use HasFactory;
    protected $table = 'account_status';
    protected $fillable = ['status'];
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function organization()
    {
        return $this->hasMany(Organization::class);
    }
}
