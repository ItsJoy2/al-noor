<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoolWallet extends Model
{
    protected $fillable = [
        'rank',
        'club',
        'shareholder',
        'director',
    ];
}
