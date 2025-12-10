<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image', 'status'];
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}

