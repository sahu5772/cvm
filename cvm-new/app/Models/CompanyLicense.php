<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLicense extends Model
{
    use HasFactory;
    protected $table = 'company_license';
    protected $fillable = ['company_id','license_by_user','license_by_year_from','license_by_year_to','license_by'];
}
