<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class JobCompanyLocation extends Model
{
    use HasFactory;

    protected $fillable = ['name','job_id','business_unit_id','is_active','created_by'];

    protected static function booted()
    {
        static::creating(function (JobCompanyLocation $jobCompanyLocation) {
            $jobCompanyLocation->created_by = Auth::user()->id;
        });
        static::updating(function (JobCompanyLocation $jobCompanyLocation) {
            $jobCompanyLocation->updated_by = Auth::user()->id;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function Locations()
    {
        return $this->belongsTo(BusinessUnit::class, 'business_unit_id')->with('country','state','city');
    }
}
