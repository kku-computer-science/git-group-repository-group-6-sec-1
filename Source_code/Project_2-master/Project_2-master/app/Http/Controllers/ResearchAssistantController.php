<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program; // ตรวจสอบว่า Model นี้มีอยู่จริง

class ResearchAssistantController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลโปรแกรมทั้งหมด
        $programs = Program::all();
        
        // ส่งตัวแปร $programs ไปยัง view และ return view นั้น
        return view('research_assistant.research-assistant', compact('programs'));
    }
    
    // method อื่น ๆ ที่ resource route ต้องการ เช่น create, store, show, edit, update, destroy
}
