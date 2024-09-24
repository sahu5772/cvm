<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Candidate extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'candidates';

    protected $fillable = ['first_name',
        'last_name',
        'email',
        'gender',
        'dob',
        'phone_number',
        'language_known',
        'designation_id',
        'department_id',
        'father_name',
        'mother_name',
        'profile_image',
        'aadhar_card',
        'pan_card',
        'country_id',
        'company_id',
        'created_by',
        'updated_by',
        'is_Active'
        ];

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function designation(){
      return  $this->belongsTo(Designation::class);
    }

    protected static function booted()
    {
        static::creating(function (Candidate $candidate) {
            $candidate->created_by = 1;
            $candidate->company_id = 1;
        });

        static::updating(function (Candidate $candidate) {
            $candidate->updated_by = Auth::user()->id;
        });
    }

    public function department(){
      return  $this->belongsTo(Department::class);
    }

    public function language(){
      return  $this->belongsTo(Language::class,'language_known','id');
    }

    public function educationalDetail(){
      return  $this->hasMany(CandidateEducationalDetail::class);
    }

    public function training(){
      return  $this->hasMany(CandidateTraining::class);
    }

    public function membership(){
      return  $this->hasMany(CandidateMembership::class);
    }

    public function country(){
      return  $this->belongsTo(Country::class);
    }

    public function project()
    {
      return $this->hasMany(ProjectReport::class);
    }

    public function getKeywordRecord()
    {
      return $this->belongsToMany(Keyword::class, 'keyword_records');
    }

    public function workExperience()
    {
      return $this->hasMany(CandidateWorkExperience::class);
    }
    public function cvs()
    {
        return $this->hasMany(CandidateCv::class, 'candidate_id');
    }



}
