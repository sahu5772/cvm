<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobSkill extends Model
{
    use HasFactory;
    protected $table = 'job_skills';
    protected $fillable = ['name','job_id','skill_id','is_active','created_by'];
    protected static function booted()
    {
        static::creating(function (JobSkill $jobSkill) {
            $jobSkill->created_by = Auth::user()->id;
        });
        static::updating(function (JobSkill $jobSkill) {
            $jobSkill->updated_by = Auth::user()->id;
        });
    }
    public function scopeActive($query)
    {
            return $query->where('is_active', '=', 'Active');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
