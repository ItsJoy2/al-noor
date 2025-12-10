<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'share_name',
        'amount',
        'total_share_quantity',
        'per_purchase_limit',
        'first_installment',
        'monthly_installment',
        'installment_months',
        'status',
    ];
    public function investors()
    {
        return $this->hasMany(Investor::class);
    }
    public function isInstallmentAvailable(): bool
    {
        return $this->installment_months > 0 && $this->monthly_installment > 0;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
