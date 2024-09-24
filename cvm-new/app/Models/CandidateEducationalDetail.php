<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateEducationalDetail extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','educational_level_id','university_id','education_mode_id','subject_id','percentage','from_year','to_year','specialization','created_by','updated_by','is_active'];

    protected static function booted()
    {
        static::creating(function (CandidateEducationalDetail $education) {
            $education->created_by = 1;

        });
        static::updating(function (CandidateEducationalDetail $education) {
            $education->updated_by = Auth::user()->id;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function educationLevel() :BelongsTo
    {
        return  $this->belongsTo(EducationalLevel::class, 'educational_level_id', 'id');
    }

    public function educationMode() :BelongsTo
    {
        return  $this->belongsTo(EducationMode::class);
    }

    public function subject() :BelongsTo
    {
        return  $this->belongsTo(Subject::class);
    }

    public function university() :BelongsTo
    {
        return  $this->belongsTo(University::class);
    }
}
