<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailSetting extends Model
{
    use HasFactory;
    protected $table = 'email_setting';
    protected $fillable = ['mail_from_name','mail_from_email','mail_host','mail_port','mail_username','mail_password','mail_encryption','company_id','created_by','updated_by'];
    protected static function booted()
    {
        static::creating(function (EmailSetting $email) {
            $email->created_by = Auth::user()->id;
            $email->company_id = Auth::user()->company_id;
        });
        static::updating(function (EmailSetting $email) {
            $email->updated_by = Auth::user()->id;
        });
    }

    public function scopeConfiguredEmail($query) {
        return $query->where('company_id', Auth::user()->company_id);
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', '=', Auth::user()->company_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 'Active');
    }


}
