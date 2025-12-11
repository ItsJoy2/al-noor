<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'details', 'status'];

    protected $casts = [
        'details' => 'array',
        'status' => 'boolean',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'method_id');
    }
}
