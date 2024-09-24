<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FundingAgency extends Model
{
    use HasFactory;
    protected $fillable = ['name','company_id','is_active'];

    protected static function booted()
    {
        static::creating(function (FundingAgency $agency) {
            $agency->company_id = Auth::user()->company_id;
        });

    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }
}
