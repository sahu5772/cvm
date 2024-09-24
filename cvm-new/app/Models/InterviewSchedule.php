<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InterviewSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'candidate_id',
        'interviewer_id',
        'interview_round_id',
        'interview_type',
        'interview_on',
        'start_time',
        'comment_for_interviewer',
        'notify_candidate',
        'comment_for_candidate',
        'rating',
        'zoom_link',
        'company_id',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        static::creating(function (InterviewSchedule $interviewSchedule) {
            $interviewSchedule->created_by = Auth::user()->id;
            $interviewSchedule->company_id = Auth::user()->company_id;
        });
        static::updating(function (InterviewSchedule $interviewSchedule) {
            $interviewSchedule->updated_by = Auth::user()->id;
        });
    }
    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class);
    }
    public function interviewRound()
    {
        return $this->belongsTo(InterviewRound::class);
    }
}
