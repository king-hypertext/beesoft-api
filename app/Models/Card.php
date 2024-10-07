<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_number',
        'org_user_id',
        'organization_id',
        'card_status',
    ];
    protected $with = ['org_user'];
    public function org_user()
    {
        return $this->belongsTo(OrgUser::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
