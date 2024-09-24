<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'job_category_id', 'job_sub_category_id', 'department_id', 'start_date', 'end_date', 'openings','job_type_id','experience','currency_id', 'payment_frequency','minimum_salary', 'maximum_salary', 'starting_salary', 'exact_salary', 'rate', 'is_remote_job', 'disclose_salary','description', 'photo', 'resume', 'dob', 'gender', 'status', 'industry_id', 'company_id','created_by', 'updated_by', 'is_active'];

    protected static function booted()
    {
        static::creating(function (Job $job) {
            $job->created_by = Auth::user()->id;
            $job->company_id = Auth::user()->company_id;
        });
        static::updating(function (Job $job) {
            $job->updated_by = Auth::user()->id;
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

    public function education()
    {
        return $this->hasMany(JobEducation::class, 'job_id')->with('education');
    }

    public function skills()
    {
        return $this->hasMany(JobSkill::class, 'job_id')->with('skill');
    }

    public function companyPerks()
    {
        return $this->hasMany(JobCompanyPerk::class, 'job_id')->with('perks');
    }

    public function companyLocations()
    {
        return $this->hasMany(JobCompanyLocation::class, 'job_id')->with('Locations');
    }

    public function jobCategory()
    {
        return $this->belongsTo(Category::class);
    }
    public function department()
    {
        return $this->belongsTo(Category::class);
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(JobSubCategory::class,'job_sub_category_id');
    }
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
