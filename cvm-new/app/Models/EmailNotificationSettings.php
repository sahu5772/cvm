<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmailNotificationSettings extends Model
{
    use HasFactory;

    protected $fillable = ['title','company_id','is_active'];

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }
}
