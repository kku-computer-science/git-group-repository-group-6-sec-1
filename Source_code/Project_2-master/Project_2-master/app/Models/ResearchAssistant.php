<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchAssistant extends Model
{
    use HasFactory;

    // กำหนดชื่อของตาราง
    protected $table = 'research_assistants';

    // ระบุฟิลด์ที่อนุญาตให้บันทึกข้อมูลได้
    protected $fillable = [
        'group_name_th',
        'group_name_en',
        'research_title_th', // เปลี่ยนจาก description_th
        'research_title_en', // เปลี่ยนจาก description_en
        'members_count',
        'form_link',
        'degree_id',
        'research_group_id',
        'project_id',
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function researchGroup()
    {
        return $this->belongsTo(ResearchGroup::class, 'research_group_id');
    }

    public function researchProject()
    {
        return $this->belongsTo(ResearchProject::class, 'project_id');
    }
}
