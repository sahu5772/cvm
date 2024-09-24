<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CandidateWorkExperience extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id', 'company_name', 'from_date', 'to_date', 'currently_working', 'designation_id', 'country_id', 'job_type_id', 'responsibilities', 'created_by', 'updated_by', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function designation() :BelongsTo
    {
        return  $this->belongsTo(Designation::class);
    }

    public function country() :BelongsTo
    {
        return  $this->belongsTo(Country::class);
    }

    public function jobType() :BelongsTo
    {
        return  $this->belongsTo(JobType::class);
    }

    protected static function booted()
    {
        static::creating(function (CandidateWorkExperience $candidate) {
            $candidate->created_by = Auth::user()->id;
            $candidate->company_id = Auth::user()->company_id;
        });

        static::updating(function (Candidate $candidate) {
            $candidate->updated_by = Auth::user()->id;
        });
    }
}
