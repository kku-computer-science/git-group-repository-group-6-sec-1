<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchAssistant;
use App\Models\ResearchAssistant;
use App\Models\ResearchGroup;
use App\Models\ResearchProject;

class ResearchAssistantController extends Controller
{
    public function index()
    {
        $researchAssistants = ResearchAssistant::all();
        return view('research_assistant.index', compact('researchAssistants'));


        $researchAssistants = ResearchAssistant::all();
        return view('research_assistant.index', compact('researchAssistants'));


    }


    public function create()
    {
        $researchGroups = ResearchGroup::all();
        $researchProjects = ResearchProject::all();
        return view('research_assistant.create', compact('researchGroups', 'researchProjects'));
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
            'form_link' => 'nullable|url',
        ]);

        //  ดึงข้อมูลกลุ่มวิจัยเพื่อใช้ `group_name_th` และ `group_name_en`
        $group = ResearchGroup::findOrFail($request->group_id);

        //  บันทึกข้อมูล
        ResearchAssistant::create([
            'member_count' => $request->member_count,
            'project_id' => $request->project_id,
            'group_id' => $request->group_id,
            'form_link' => $request->form_link,
            'research_group_id' => $request->group_id,
            'group_name_th' => $group->group_name_th,
            'group_name_en' => $group->group_name_en,
        ]);

        return redirect()->route('researchAssistant.index')->with('success', 'เพิ่มผู้ช่วยวิจัยสำเร็จ!');
    }

    //ลบ
    public function destroy($id)
    {
        // ค้นหาข้อมูลที่ต้องการลบ
        $assistant = ResearchAssistant::find($id);

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$assistant) {
            return redirect()->route('researchAssistant.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ทำการลบข้อมูล
        $assistant->delete();

        // กลับไปที่หน้ารายการ พร้อมแจ้งเตือนว่าลบสำเร็จ
        return redirect()->route('researchAssistant.index')->with('success', 'ลบข้อมูลสำเร็จ!');
    }

    //แก้ไข อัพเดท

    // ฟังก์ชันแก้ไขข้อมูล
    public function edit($id)
    {
        $researchAssistant = ResearchAssistant::findOrFail($id);
        $researchGroups = ResearchGroup::all();
        $researchProjects = ResearchProject::all();
        
        return view('research_assistant.edit', compact('researchAssistant', 'researchGroups', 'researchProjects'));
    }

    // ฟังก์ชันอัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
        //  ตรวจสอบค่าจากฟอร์ม
        $validated = $request->validate([
            'member_count' => 'required|integer',
            'project_id' => 'required|exists:research_projects,id',
            'group_id' => 'required|exists:research_groups,id',
            'form_link' => 'nullable|url',
        ]);

        //  ดึงข้อมูลกลุ่มวิจัยเพื่อใช้ group_name_th และ group_name_en
        $group = ResearchGroup::findOrFail($request->group_id);

        //  บันทึกข้อมูล
        ResearchAssistant::create([
            'member_count' => $request->member_count,
            'project_id' => $request->project_id,
            'group_id' => $request->group_id,
            'form_link' => $request->form_link,
            'research_group_id' => $request->group_id,
            'group_name_th' => $group->group_name_th,
            'group_name_en' => $group->group_name_en,
        ]);

        return redirect()->route('researchAssistant.index')->with('success', 'เพิ่มผู้ช่วยวิจัยสำเร็จ!');
    }

    //ลบ
    public function destroy($id)
    {
        // ค้นหาข้อมูลที่ต้องการลบ
        $assistant = ResearchAssistant::find($id);

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$assistant) {
            return redirect()->route('researchAssistant.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ทำการลบข้อมูล
        $assistant->delete();

        // กลับไปที่หน้ารายการ พร้อมแจ้งเตือนว่าลบสำเร็จ
        return redirect()->route('researchAssistant.index')->with('success', 'ลบข้อมูลสำเร็จ!');
    }

    //แก้ไข อัพเดท

    // ฟังก์ชันแก้ไขข้อมูล
    public function edit($id)
    {
        $researchAssistant = ResearchAssistant::findOrFail($id);
        $researchGroups = ResearchGroup::all();
        $researchProjects = ResearchProject::all();

        return view('research_assistant.edit', compact('researchAssistant', 'researchGroups', 'researchProjects'));
    }

    // ฟังก์ชันอัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'research_group_id' => 'required|exists:research_groups,id',
            'group_name_en' => 'required|string',
            'project_id' => 'required|exists:research_projects,id',
            'member_count' => 'required|integer|min:1',
            'group_name_en' => 'required|string',
            'project_id' => 'required|exists:research_projects,id',
            'member_count' => 'required|integer|min:1',
            'form_link' => 'required|url',
            
        ]);

        $researchAssistant = ResearchAssistant::findOrFail($id);
        $researchGroup = ResearchGroup::find($request->research_group_id);

        $researchAssistant->update([
            'group_name_th' => $researchGroup->group_name_th,
            'group_name_en' => $request->group_name_en,
            'research_group_id' => $request->research_group_id,
            'project_id' => $request->project_id,
            'member_count' => $request->member_count,
            'form_link' => $request->form_link,
        ]);

        return redirect()->route('researchAssistant.index')->with('success', 'อัปเดตข้อมูลสำเร็จ!');

        ]);

        $researchAssistant = ResearchAssistant::findOrFail($id);
        $researchGroup = ResearchGroup::find($request->research_group_id);

        $researchAssistant->update([
            'group_name_th' => $researchGroup->group_name_th,
            'group_name_en' => $request->group_name_en,
            'research_group_id' => $request->research_group_id,
            'project_id' => $request->project_id,
            'member_count' => $request->member_count,
            'form_link' => $request->form_link,
        ]);

        return redirect()->route('researchAssistant.index')->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }
}
