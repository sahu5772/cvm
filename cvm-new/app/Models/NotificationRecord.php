<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationRecord extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'notifiable', 'data', 'company_id', 'read_at'];

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

}
