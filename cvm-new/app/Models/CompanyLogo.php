<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyLogo extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'company_id', 'created_by', 'updated_by', 'is_active'];

    protected static function booted()
    {
        static::creating(function (CompanyLogo $companyLogo) {
            $companyLogo->created_by = Auth::user()->id;
        });
    }
}
