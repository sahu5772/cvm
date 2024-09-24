<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'job_sub_categories';
    protected $fillable = ['name','job_category_id','created_by','updated_by','is_active'];

    protected static function booted()
    {
        static::creating(function (SubCategory $subcategory) {
            $subcategory->created_by = Auth::user()->id;
            $subcategory->company_id = Auth::user()->company_id;
        });
        static::updating(function (SubCategory $subcategory) {
            $subcategory->updated_by = Auth::user()->id;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'job_category_id','id');
    }
    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }
}
