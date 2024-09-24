<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateKeyword extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id','keyword_id','company_id','phase_id','industry_id','sector_id'];

    protected static function booted()
    {
        static::creating(function (CandidateKeyword $keyword) {
            $keyword->company_id = Auth::user()->company_id;
        });
    }

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

}
