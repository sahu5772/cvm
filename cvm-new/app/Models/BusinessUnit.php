<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BusinessUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'address', 'pin_code', 'country_id',  'state_id',  'city_id',   'timezone_id', 'company_id', 'created_by', 'updated_by', 'is_Active'];

    protected static function booted()
    {
        //comment this code while seeding
        static::creating(function (BusinessUnit $businessUnit) {
            $businessUnit->created_by = Auth::user()->id;
        });

        static::updating(function (BusinessUnit $businessUnit) {
            $businessUnit->updated_by = Auth::user()->id;
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

    public function timezone(){
        return  $this->belongsTo(Timezone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }
}
