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
            <p class="card-description">กรอกข้อมูลผู้ช่วยวิจัย</p>
            <form action="{{ route('researchAssistant.store') }}" method="POST">
                @csrf

                <!-- เลือกกลุ่มวิจัย -->
                <div class="form-group">
                    <label for="group_id">ชื่อกลุ่มวิจัย (ภาษาไทย)</label>
                    <select class="form-control" id="group_id" name="group_id" required>
                        <option value="" disabled selected>เลือกชื่อกลุ่มวิจัย</option>
                        @foreach($researchGroups as $group)
                        <option value="{{ $group->id }}" data-group-en="{{ $group->group_name_en }}">
                            {{ $group->group_name_th }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- แสดงชื่อกลุ่มวิจัย (ภาษาอังกฤษ) อัตโนมัติ -->
                <div class="form-group">
                    <label for="group_name_en">ชื่อกลุ่มวิจัย (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" id="group_name_en" name="group_name_en" readonly>
                </div>

                <!-- เลือกงานวิจัย -->
                <div class="form-group">
                    <label for="project_id">ชื่องานวิจัย</label>
                    <select class="form-control" id="project_id" name="project_id" required>
                        <option value="" disabled selected>เลือกชื่องานวิจัย</option>
                        @foreach($researchProjects as $project)
                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- ระบุจำนวนผู้ช่วยวิจัย -->
                <div class="form-group">
                    <label for="member_count">จำนวนผู้ช่วยวิจัย</label>
                    <input type="number" class="form-control" id="member_count" name="member_count" required>
                </div>

                <button type="submit" class="btn btn-primary">บันทึก</button>
                <a href="{{ route('researchAssistant.index') }}" class="btn btn-secondary">กลับ</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('group_id').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    let groupNameEn = selectedOption.getAttribute('data-group-en');
    document.getElementById('group_name_en').value = groupNameEn;
});
</script>

@endsection
