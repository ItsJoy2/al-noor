<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'quantity',
        'purchase_type',
        'total_amount',
        'paid_amount',
        'paid_installments',
        'pending_invoices',
        'status',
        'activated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
