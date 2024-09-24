<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateMembership extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id','membership_id','membership_number','year_of_award','type', 'created_by', 'updated_by', 'company_id'];

    protected static function booted()
    {
        static::creating(function (CandidateMembership $candidate) {
          $candidate->created_by = Auth::user()->id;
          $candidate->company_id = Auth::user()->company_id;
        });

        static::updating(function (CandidateMembership $candidate) {
            $candidate->updated_by = Auth::user()->id;
        });
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
