<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
        'currency_symbol',
        'currency_code',
        'is_active',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }
}
