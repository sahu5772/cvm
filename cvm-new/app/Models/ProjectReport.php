<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReport extends Model
{
  use HasFactory;

    protected $table = 'candidate_projects';

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
    'project_length',
    'created_by',
    'updated_by',
    'is_Active'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function designation()
    {
        return  $this->belongsTo(Designation::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class,'sector_id','id');
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class,'phase_id','id');
    }

    public function fundingAgency()
    {
        return $this->belongsTo(Phase::class,'funding_agency_id','id');
    }

    public function terrain()
    {
        return $this->belongsTo(Terrains::class,'terrain_id','id');
    }

    public function contract()
    {
        return $this->belongsTo(ContractMode::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
