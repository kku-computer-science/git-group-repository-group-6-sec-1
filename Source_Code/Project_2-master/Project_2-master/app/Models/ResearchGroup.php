<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name_th', 'group_name_en', 'group_detail_th', 'group_detail_en', 'group_desc_th', 'group_desc_en', 'group_image'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class,'work_of_research_groups')->withPivot('role');
        // OR return $this->hasOne('App\Phone');
    }
    public function product(){
        return $this->hasOne(Product::class,'group_id');
    }
<<<<<<< HEAD:Source_Code/Project_2-master/Project_2-master/app/Models/ResearchGroup.php
=======

>>>>>>> origin/Thanachai_0183:Source_code/Project_2-master/Project_2-master/app/Models/ResearchGroup.php
    //เพิ่มเติมให้  researchAssistants
    public function researchAssistants()
    {
        return $this->hasMany(ResearchAssistant::class);
    }
<<<<<<< HEAD:Source_Code/Project_2-master/Project_2-master/app/Models/ResearchGroup.php
=======

>>>>>>> origin/Thanachai_0183:Source_code/Project_2-master/Project_2-master/app/Models/ResearchGroup.php

}
