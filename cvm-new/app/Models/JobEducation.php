<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobEducation extends Model
{
    use HasFactory;
    protected $table = 'job_educational_requirements';
    protected $fillable = ['name','job_id','educational_level_id','is_active','created_by'];
    protected static function booted()
    {
        static::creating(function (JobEducation $jobEducation) {
            $jobEducation->created_by = Auth::user()->id;
        });
        static::updating(function (JobEducation $jobEducation) {
            $jobEducation->updated_by = Auth::user()->id;
        });
    }
    public function scopeActive($query)
    {
            return $query->where('is_active', '=', 'Active');
    }

    public function education()
    {
        return $this->belongsTo(EducationalLevel::class, 'educational_level_id');
    }
}
