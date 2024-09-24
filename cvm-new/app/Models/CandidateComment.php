<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateComment extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','company_id','contact_through','other_option','comment', 'created_by', 'updated_by'];
}
