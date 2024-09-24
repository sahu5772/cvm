<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CompanyPerk extends Model
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
    protected static function booted()
    {
        static::creating(function (CompanyPerk $companyPerk) {
            $companyPerk->created_by = Auth::user()->id;
            $companyPerk->company_id = Auth::user()->company_id;
        });
        static::updating(function (CompanyPerk $companyPerk) {
            $companyPerk->updated_by = Auth::user()->id;
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
