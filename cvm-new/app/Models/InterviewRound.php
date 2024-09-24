<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InterviewRound extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
        'color',
        'company_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        static::creating(function (InterviewRound $interviewRound) {
            $interviewRound->created_by = Auth::user()->id;
            $interviewRound->company_id = Auth::user()->company_id;
        });
        static::updating(function (InterviewRound $interviewRound) {
            $interviewRound->updated_by = Auth::user()->id;
        });
    }
    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }
}
