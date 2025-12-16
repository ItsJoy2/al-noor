<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusSetting extends Model
{
    protected $fillable = [
        'level1',
        'level2',
        'level3',
        'level4',
        'level5',
        'rank_pool',
        'club_pool',
        'shareholder_pool',
        'director_pool',
        'reactivation_charge',
        'max_pending_installments',
        'club1_percent',
        'club2_percent',
        'club3_percent',
        'rank1_percent',
        'rank2_percent',
        'rank3_percent',
    ];
}
