<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'job_categories';
    protected $fillable = ['name','created_by','updated_by','is_active'];

    protected static function booted()
    {
        static::creating(function (Category $category) {
            $category->created_by = Auth::user()->id;
            $category->company_id = Auth::user()->company_id;
        });
        static::updating(function (Category $category) {
            $category->updated_by = Auth::user()->company_id;
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
