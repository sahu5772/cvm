<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['name','created_by','updated_by','is_active','company_id'];

    protected static function booted()
    {
        static::creating(function (Skill $skill) {
            $skill->created_by = Auth::user()->id;
            $skill->company_id = Auth::user()->company_id;
        });

        static::updating(function (Skill $skill) {
            $skill->updated_by = Auth::user()->id;
        });
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
