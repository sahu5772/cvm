<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sector_id', 'industry_id', 'company_id'];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
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
