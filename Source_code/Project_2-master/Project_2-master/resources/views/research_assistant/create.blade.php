@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">เพิ่มผู้ช่วยวิจัย</h4>
            <p class="card-description">กรอกข้อมูลผู้รับสมัคร และแก้ไขผู้ช่วยวิจัย</p>
            <form action="{{ route('researchAssistant.store') }}" method="POST" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="group_name_th">ชื่อกลุ่มวิจัย (ภาษาไทย)</label>
                    <select class="form-control" id="group_name_th" name="group_name_th" required>
                        <option value="" disabled selected>เลือกชื่อกลุ่มวิจัย (ภาษาไทย)</option>
                        @foreach($researchGroups as $group)
                        <option value="{{ $group->group_name_th }}">{{ $group->group_name_th }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="group_name_en">ชื่อกลุ่มวิจัย (ภาษาอังกฤษ)</label>
                    <select class="form-control" id="group_name_en" name="group_name_en" required>
                        <option value="" disabled selected>เลือกชื่อกลุ่มวิจัย (ภาษาอังกฤษ)</option>
                        @foreach($researchGroups as $group)
                        <option value="{{ $group->group_name_en }}">{{ $group->group_name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="degree_id">หลักสูตร (Degree)</label>
                    <select class="form-control" id="degree_id" name="degree_id" required>
                        <option value="" disabled selected>เลือกหลักสูตร</option>
                        @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}">{{ $degree->degree_name_th }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_name">ชื่องานวิจัย</label>
                    <select class="form-control" id="project_name" name="project_name" required>
                        <option value="" disabled selected>เลือกชื่องานวิจัย</option>
                        @foreach($researchProjects as $project)
                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="research_title_th">ชื่องานวิจัย (ภาษาไทย)</label>
                    <textarea class="form-control" id="research_title_th" name="research_title_th" rows="3" placeholder="กรอกชื่องานวิจัย (ภาษาไทย)" required></textarea>
                </div>
                <div class="form-group">
                    <label for="research_title_en">ชื่องานวิจัย (ภาษาอังกฤษ)</label>
                    <textarea class="form-control" id="research_title_en" name="research_title_en" rows="3" placeholder="กรอกชื่องานวิจัย (ภาษาอังกฤษ)" required></textarea>
                </div>
                <div class="form-group">
                    <label for="members_count">จำนวนผู้ช่วยวิจัย</label>
                    <input type="number" class="form-control" id="members_count" name="members_count" placeholder="ระบุจำนวนผู้ช่วยวิจัย" required>
                </div>
                <div class="form-group">
                    <label for="form_link">Form Link</label>
                    <input type="url" class="form-control" id="form_link" name="form_link" placeholder="ระบุลิงก์ฟอร์ม" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2">บันทึก</button>
                <a href="{{ route('researchAssistant.index') }}" class="btn btn-secondary">กลับ</a>
            </form>
        </div>
    </div>
</div>
@endsection
