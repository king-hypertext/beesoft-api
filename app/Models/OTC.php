<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTC extends Model
{
    use HasFactory;
    protected $table = 'login_otc';
    protected $fillable = [
        'user_id',
        'code',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
