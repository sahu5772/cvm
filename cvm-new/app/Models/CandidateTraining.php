<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateTraining extends Model
{
    use HasFactory;

    protected  $fillable = [
        'training_center',
        'candidate_id',
        'certificate_id',
        'company_id',
        'year_of_completion',
        'duration',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function (CandidateTraining $candidate) {
          $candidate->created_by = Auth::user()->id;
          $candidate->company_id = Auth::user()->company_id;
        });

        static::updating(function (CandidateTraining $candidate) {
            $candidate->updated_by = Auth::user()->id;
        });
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

}
