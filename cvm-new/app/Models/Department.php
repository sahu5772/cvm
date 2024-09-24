<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
        'company_id',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }
}
