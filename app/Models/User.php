<?php

namespace App\Models;

use App\Models\Investor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable // implements MustVerifyEmail (Enable when you want)
{
    use HasFactory, HasApiTokens, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'funding_wallet',
        'bonus_wallet',
        'refer_by',
        'refer_code',
        'is_active',
        'last_activated_at',
        'is_block',
        'password',
        'birthday',
        'nid_or_passport',
        'address',
        'image',
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $casts = [
        'last_activated_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_block' => 'boolean',
        'kyc_status' => 'boolean',
    ];
    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refer_by');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'refer_by');
    }
    public function investors(): HasMany
    {
        return $this->hasMany(Investor::class);
    }

    public function hasReceivedActivationBonus(): bool
    {
        return $this->last_activated_at !== null;
    }
    public function totalTeamMembersCount(): int
    {
        $count = $this->referrals()->count();

        foreach ($this->referrals as $referral) {
            $count += $referral->totalTeamMembersCount();
        }

        return $count;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->refer_code)) {
                $user->refer_code = self::generateReferCode();
            }
        });
    }
    public static function generateReferCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        } while (self::where('refer_code', $code)->exists());

        return $code;
    }
}

