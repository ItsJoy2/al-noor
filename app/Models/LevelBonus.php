<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelBonus extends Model
{
    protected $fillable = [
        'user_id',
        'from_user',
        'investor_id',
        'amount',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user');
    }
}
