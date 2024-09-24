<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobCompanyPerk extends Model
{
    use HasFactory;
    protected $table = 'job_company_perks';
    protected $fillable = ['name','job_id','company_perk_id','is_active','created_by'];
    protected static function booted()
    {
        static::creating(function (JobCompanyPerk $jobCompanyPerk) {
            $jobCompanyPerk->created_by = Auth::user()->id;
        });
        static::updating(function (JobCompanyPerk $jobCompanyPerk) {
            $jobCompanyPerk->updated_by = Auth::user()->id;
        });
    }
    public function scopeActive($query)
    {
            return $query->where('is_active', '=', 'Active');
    }

    public function perks()
    {
        return $this->belongsTo(CompanyPerk::class, 'company_perk_id');
    }
}
