<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchAssistant extends Model
{
    use HasFactory;

    protected $table = 'research_assistants';

    protected $fillable = [
        'member_count',
        'project_id',
        'group_id', // ต้องใช้ group_id ไม่ใช่ research_group_id
        'research_group_id',
        'group_name_th',
        'group_name_en',
        'form_link',
    ];

    public $timestamps = false; // ปิด timestamps

    // ความสัมพันธ์กับ ResearchGroup
    public function researchGroup()
    {
        return $this->belongsTo(ResearchGroup::class, 'group_id');
    }

    // ความสัมพันธ์กับ ResearchProject
    public function researchProject()
    {
        return $this->belongsTo(ResearchProject::class, 'project_id');
    }
}
