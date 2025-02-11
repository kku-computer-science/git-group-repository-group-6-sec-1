<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD

class ResearchAssistantController extends Controller
{
    //
}
=======
use App\Models\Degree;
use App\Models\ResearchGroup;
use App\Models\ResearchProject;
use App\Models\ResearchAssistant;

class ResearchAssistantController extends Controller
{
    public function index()
    {
        return view('research_assistant.index');
    }
    
    public function create()
    {
        $degrees = Degree::all(); // ดึงข้อมูลจากตาราง degrees
        $researchGroups = ResearchGroup::all(); // ดึงข้อมูล research_groups ทั้งหมด
        $researchProjects = ResearchProject::all(); // ดึงข้อมูลชื่องานวิจัยทั้งหมด
        return view('research_assistant.create', compact('degrees', 'researchGroups', 'researchProjects'));
    }

    public function store(Request $request)
    {
        // 🔍 Debug: ดูค่าที่ส่งมาก่อน
        // dd($request->all());  // ✅ ให้ลบหรือย้ายไปหลัง validate()

        // ✅ ตรวจสอบค่าที่ส่งมา (ชื่อฟิลด์ต้องตรงกับฐานข้อมูล)
        $request->validate([
            'group_name_th' => 'required|string|max:255',
            'group_name_en' => 'required|string|max:255',
            'degree_id' => 'required|exists:degrees,id',
            'research_group_id' => 'required|exists:research_groups,id',
            'project_id' => 'required|exists:research_projects,id', // ✅ เพิ่ม project_id
            'research_title_th' => 'required|string', // ✅ เปลี่ยนจาก description_th
            'research_title_en' => 'required|string', // ✅ เปลี่ยนจาก description_en
            'members_count' => 'required|integer',
            'form_link' => 'required|url',
        ]);

        // ✅ Debug: ตรวจสอบข้อมูลก่อนบันทึก
        // dd($request->all());

        // ✅ บันทึกข้อมูลลงตาราง `research_assistants`
        ResearchAssistant::create($request->all());

        // ✅ Redirect กลับหน้าหลัก พร้อมแจ้งเตือนสำเร็จ
        return redirect()->route('researchAssistant.index')->with('success', 'เพิ่มผู้ช่วยวิจัยสำเร็จ!');
    }
}
>>>>>>> origin/Thanachai_0183
