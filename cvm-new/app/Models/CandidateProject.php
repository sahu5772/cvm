<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'candidate_id',
        'name',
        'from',
        'to',
        'designation_id',
        'industry_id',
        'sector_id',
        'phase_id',
        'employer_name',
        'employer_type_id',
        'project_type',
        'country_id',
        'state_id',
        'city_id',
        'project_length',
        'project_cost',
        'funding_agency_id',
        'contract_mode_id',
        'terrain_id',
        'created_by',
        'updated_by',
        'is_Active'
    ];

    protected static function booted()
    {
        static::creating(function (CandidateProject $candidate) {
          $candidate->created_by = 1;
          $candidate->company_id = 1;
        });

        static::updating(function (CandidateProject $candidate) {
            $candidate->updated_by = Auth::user()->id;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function candidate(){
      return  $this->belongsTo(Candidate::class);
    }

    public function designation(){
      return  $this->belongsTo(Designation::class);
    }

    public function industry(){
      return  $this->belongsTo(Industry::class);
    }

    public function sector(){
      return  $this->belongsTo(Sector::class);
    }

    public function phase(){
      return  $this->belongsTo(Phase::class);
    }

    public function employerType(){
      return  $this->belongsTo(Phase::class);
    }

    public function country(){
      return  $this->belongsTo(Country::class);
    }

    public function state(){
      return  $this->belongsTo(State::class);
    }

    public function city(){
      return  $this->belongsTo(City::class);
    }

    public function fundingAgency(){
      return  $this->belongsTo(FundingAgency::class);
    }

    public function contractMode(){
      return  $this->belongsTo(ContractMode::class);
    }

    public function terrain(){
      return  $this->belongsTo(Terrains::class);
    }
}
