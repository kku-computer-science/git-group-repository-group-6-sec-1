<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    public function program()
    {
        return $this->hasMany(Program::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }
<<<<<<< HEAD
=======

    //เพิ่มเติม
    public function researchAssistants()
    {
    return $this->hasMany(ResearchAssistant::class);
    }
>>>>>>> origin/Thanachai_0183
}
