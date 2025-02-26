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
<<<<<<< HEAD:Source_Code/Project_2-master/Project_2-master/app/Models/Degree.php
<<<<<<< HEAD:Source_Code/Project_2-master/Project_2-master/app/Models/Degree.php
=======

>>>>>>> origin/Thanachai_0183:Source_code/Project_2-master/Project_2-master/app/Models/Degree.php

    //เพิ่มเติม
    public function researchAssistants()
    {
    return $this->hasMany(ResearchAssistant::class);
    }
<<<<<<< HEAD:Source_Code/Project_2-master/Project_2-master/app/Models/Degree.php
=======
>>>>>>> origin/Thanakrit_2664:Source_code/Project_2-master/Project_2-master/app/Models/Degree.php
=======

>>>>>>> origin/Thanachai_0183:Source_code/Project_2-master/Project_2-master/app/Models/Degree.php
}
