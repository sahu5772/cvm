<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordRecord extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','keyword_id'];

    public function getKeyword(){
        return  $this->belongsTo(Keyword::class,'keyword_id','id');
    }
}
