<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViewDashboardData extends Model
{
    use HasFactory;
    protected $table = 'dashboard_view';
    public function scopeCompany($query)
    {
        return $query->where('id', '=', Auth::user()->company_id);
    }
}
