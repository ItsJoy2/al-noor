<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReactivationLog extends Model
{
    protected $fillable = [
        'investor_id',
        'user_id',
        'charge_amount',
        'total_paid',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
