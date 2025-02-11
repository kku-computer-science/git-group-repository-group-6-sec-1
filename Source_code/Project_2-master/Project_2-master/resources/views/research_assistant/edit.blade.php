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
            <h4 class="card-title">แก้ไขข้อมูลผู้ช่วยวิจัย</h4>
            <form action="{{ route('researchAssistant.update', $researchAssistant->id) }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT')

                <!-- ชื่อกลุ่มวิจัย (ภาษาไทย) -->
                <div class="form-group">
                    <label for="research_group_id">ชื่อกลุ่มวิจัย (ภาษาไทย)</label>
                    <select class="form-control" id="research_group_id" name="research_group_id" required>
                        @foreach($researchGroups as $group)
                        <option value="{{ $group->id }}" data-group-en="{{ $group->group_name_en }}"
                            {{ $group->id == $researchAssistant->research_group_id ? 'selected' : '' }}>
                            {{ $group->group_name_th }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- ชื่อกลุ่มวิจัย (ภาษาอังกฤษ) - ถูกเติมอัตโนมัติ -->
                <div class="form-group">
                    <label for="group_name_en">ชื่อกลุ่มวิจัย (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" id="group_name_en" name="group_name_en" value="{{ $researchAssistant->group_name_en }}" readonly>
                </div>

                <!-- ชื่องานวิจัย -->
                <div class="form-group">
                    <label for="project_id">ชื่องานวิจัย (Research name)</label>
                    <select class="form-control" id="project_id" name="project_id" required>
                        @foreach($researchProjects as $project)
                        <option value="{{ $project->id }}" {{ $project->id == $researchAssistant->project_id ? 'selected' : '' }}>
                            {{ $project->project_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- จำนวนผู้ช่วยวิจัย -->
                <div class="form-group">
                    <label for="member_count">จำนวนผู้ช่วยวิจัย</label>
                    <input type="number" class="form-control" id="member_count" name="member_count" value="{{ $researchAssistant->member_count }}" required>
                </div>

                <button type="submit" class="btn btn-primary mr-2">บันทึก</button>
                <a href="{{ route('researchAssistant.index') }}" class="btn btn-secondary">กลับ</a>
            </form>

            <!-- JavaScript เพื่อเติมค่าอัตโนมัติ -->
            <script>
                document.getElementById('research_group_id').addEventListener('change', function() {
                    let selectedOption = this.options[this.selectedIndex];
                    let groupNameEn = selectedOption.getAttribute('data-group-en');
                    document.getElementById('group_name_en').value = groupNameEn;
                });
            </script>
        </div>
    </div>
</div>
@endsection
