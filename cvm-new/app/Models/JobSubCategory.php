<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_category_id',
        'name',
        'is_active'
    ];
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'job_category_id');
    }
}
