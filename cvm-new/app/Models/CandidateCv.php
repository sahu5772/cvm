<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateCv extends Model
{
    use HasFactory;
    protected $fillable = ['file','candidate_id','created_by', 'updated_by', 'company_id'];

    protected static function booted()
    {
        static::creating(function (CandidateCv $candidateCv) {
            $candidateCv->created_by = Auth::user()->id;
            $candidateCv->company_id = Auth::user()->company_id;

        });
        static::updating(function (CandidateCv $candidateCv) {
            $candidateCv->updated_by = Auth::user()->id;
        });
    }
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
