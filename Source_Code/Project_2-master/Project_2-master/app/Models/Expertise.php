<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $fillable = [
        'expert_name',
        'expert_name_th',
        'expert_name_zh',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expertise()
    {
        return $this->hasMany(Expertise::class);
    }
}