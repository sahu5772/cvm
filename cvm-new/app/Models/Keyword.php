<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory;
    protected $fillable = ['keyword','phase_id','company_id','is_active','created_by','updated_by'];

    public function scopeActive($query)
    {
            return $query->where('is_active', '=', 'Active');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    protected static function booted()
    {
        static::creating(function (Keyword $keyword) {
            $keyword->created_by = Auth::user()->id;
            $keyword->company_id = Auth::user()->company_id;
        });

        static::updating(function (Keyword $keyword) {
            $keyword->updated_by = Auth::user()->id;
        });
    }

     public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function candidate()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_keywords');
    }

    public function getCandidate()
    {
        return $this->belongsToMany(CandidateKeyword::class, 'keyword_records');
    }

}
