<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'card_number',
        'org_user_id',
        'card_status',
    ];
    protected $with = [/* 'org_user', */'user'];
    public function user()
    {
        return $this->belongsTo(OrgUser::class);
    }

    public function card_status()
    {
        return $this->belongsTo(UserAccountStatus::class, 'id', 'card_status');
    }
}
