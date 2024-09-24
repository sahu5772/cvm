<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Company extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['name', 'email', 'phone_number', 'website','license_by_user','license_by_year','currency_id', 'timezone_id', 'created_by', 'updated_by', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function getCompanySetting(){
      return  $this->hasOne(CompanySetting::class);
    }

    public function getCompanyLogo(){
      return  $this->hasOne(CompanyLogo::class);
    }

    public function getLicense(){
      return  $this->hasOne(CompanyLicense::class);
    }
}
