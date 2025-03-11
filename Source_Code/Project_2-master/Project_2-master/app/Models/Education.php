<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'level', 'uname', 'university_en', 'university_zh', 
        'qua_name', 'qua_name_en', 'qua_name_zh', 'year', 'year_anno_domino'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
