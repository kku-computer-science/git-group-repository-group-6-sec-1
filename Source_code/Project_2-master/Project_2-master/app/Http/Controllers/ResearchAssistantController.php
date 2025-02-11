<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchAssistant;
use App\Models\ResearchGroup;
use App\Models\ResearchProject;

class ResearchAssistantController extends Controller
{
    public function index()
    {
        $researchAssistants = ResearchAssistant::all();
        return view('research_assistant.index', compact('researchAssistants'));
    }

    public function create()
    {
        $researchGroups = ResearchGroup::all();
        $researchProjects = ResearchProject::all();
        return view('research_assistant.create', compact('researchGroups', 'researchProjects'));
    }

    public function store(Request $request)
    {
        //  ตรวจสอบค่าจากฟอร์ม
        $validated = $request->validate([
            'member_count' => 'required|integer',
            'project_id' => 'required|exists:research_projects,id',
            'group_id' => 'required|exists:research_groups,id',
        ]);

        //  ดึงข้อมูลกลุ่มวิจัยเพื่อใช้ `group_name_th` และ `group_name_en`
        $group = ResearchGroup::findOrFail($request->group_id);

        //  บันทึกข้อมูล
        ResearchAssistant::create([
            'member_count' => $request->member_count,
            'project_id' => $request->project_id,
            'group_id' => $request->group_id,
            'research_group_id' => $request->group_id,
            'group_name_th' => $group->group_name_th,
            'group_name_en' => $group->group_name_en,
        ]);

        return redirect()->route('researchAssistant.index')->with('success', 'เพิ่มผู้ช่วยวิจัยสำเร็จ!');
    }
}
