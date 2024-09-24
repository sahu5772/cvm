<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateAddress extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'country_id', 'state_id', 'city_id', 'address', 'created_by', 'updated_by', 'company_id'];

    protected static function booted()
    {
        static::creating(function (CandidateAddress $address) {
            $address->created_by = Auth::user()->id;
            $address->company_id = Auth::user()->company_id;

        });
        static::updating(function (CandidateAddress $address) {
            $address->updated_by = Auth::user()->id;
        });
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
}
