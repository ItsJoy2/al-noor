<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivationSetting extends Model
{
    protected $table = 'activation_settings';

    protected $fillable = [
        'activation_amount',
        'activation_bonus',
        'referral_bonus',
        'activation_duration_months',
    ];
}

