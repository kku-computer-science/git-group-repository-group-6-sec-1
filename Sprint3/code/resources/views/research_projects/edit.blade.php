@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('research_projects.edit_title'))

@section('content')
<style>
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 5px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('research_projects.confirm_title') }}</strong> {{ __('research_projects.confirm_text') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card col-md-12" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('research_projects.edit_title') }}</h4>
            <p class="card-description">{{ __('research_projects.edit_description') }}</p>
            <form action="{{ route('researchProjects.update', $researchProject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_name') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="project_name" class="form-control" style="height:90px">{{ $researchProject->project_name }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_start') }}</b></p>
                    <div class="col-sm-4">
                        <input type="date" name="project_start" value="{{ $researchProject->project_start }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_end') }}</b></p>
                    <div class="col-sm-4">
                        <input type="date" name="project_end" value="{{ $researchProject->project_end }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.fund_source') }}</b></p>
                    <div class="col-sm-9">
                        <select id="fund" style="width: 200px;" class="custom-select my-select" name="fund">
                            <option value="" disabled {{ !$researchProject->fund ? 'selected' : '' }}>{{ __('research_projects.select_fund') }}</option>
                            @foreach($funds as $f)
                                <option value="{{ $f->id }}" {{ $f->id == $researchProject->fund_id ? 'selected' : '' }}>
                                    {{ $f->fund_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <p class="col-sm-3"><b>{{ __('research_projects.year') }}</b></p>
                    <div class="col-sm-8">
                        <input type="number" name="project_year" class="form-control" placeholder="{{ __('research_projects.year') }}" value="{{ $researchProject->project_year }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.budget') }}</b></p>
                    <div class="col-sm-4">
                        <input type="number" name="budget" value="{{ $researchProject->budget }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.support_resource') }}</b></p>
                    <div class="col-sm-8">
                        <input type="text" name="responsible_department" class="form-control" placeholder="{{ __('research_projects.placeholder.support_resource') }}" value="{{ $researchProject->responsible_department }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_note') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="note" class="form-control" style="height:90px">{{ $researchProject->note }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_status') }}</b></p>
                    <div class="col-sm-8">
                        <select id="status" class="custom-select my-select" style="width: 200px;" name="status">
                            <option value="1" {{ 1 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.submitted') }}</option>
                            <option value="2" {{ 2 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.in_progress') }}</option>
                            <option value="3" {{ 3 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.closed') }}</option>
                        </select>
                    </div>
                </div>
                <!-- ผู้รับผิดชอบโครงการ -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table">
                        <tr>
                            <th>{{ __('research_projects.label.project_head') }}</th>
                        </tr>
                        <tr>
                            <td>
                                <select id="head0" style="width: 200px;" name="head" class="my-select">
                                    <option value="">{{ __('research_projects.select_member') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $researchProject->users && $researchProject->users->contains('id', $user->id) && optional($researchProject->users->find($user->id))->pivot->role == 2 ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'th' ? $user->fname_th . ' ' . $user->lname_th : $user->fname_en . ' ' . $user->lname_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- สมาชิกภายใน -->
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <table class="table" id="dynamicAddRemove">
                        <tr>
                            <th width="522.98px">
                                {{ __('research_projects.label.project_member') }}
                                ({{ __('research_projects.label.project_member_within') }})
                            </th>
                            <th><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add"><i class="mdi mdi-plus"></i></button></th>
                        </tr>
                    </table>
                </div>
                <!-- สมาชิกภายนอก -->
                <div class="form-group row">
                    <label for="exampleInputpaper_author" class="col-sm-3 col-form-label">{{ __('research_projects.label.project_member') }} ({{ __('research_projects.label.project_member_outside') }})</label>
                    <div class="col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-bordered w-75" id="dynamic_field">
                                <tr>
                                    <td><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">{{ __('research_projects.submit_button') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('researchProjects.index') }}">{{ __('research_projects.back_button') }}</a>
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script>
    $(document).ready(function() {
        $("#head0").select2();

        // โหลดสมาชิกภายในจาก $researchProject->users
        var users = <?php echo json_encode($researchProject->users ?? []); ?>;
        var i = 0;

        for (i = 0; i < users.length; i++) {
            var user = users[i];
            if (user.pivot && user.pivot.role !== 2) { // ไม่ใช่หัวหน้าโครงการ
                $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i + '][userid]" style="width: 200px;" class="my-select"><option value="">{{ __('research_projects.select_member') }}</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ app()->getLocale() == "th" ? $u->fname_th." ".$u->lname_th : $u->fname_en." ".$u->lname_en }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>');
                document.getElementById("selUser" + i).value = user.id;
                $("#selUser" + i).select2();
            }
        }

        $("#add-btn2").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i + '][userid]" style="width: 200px;" class="my-select"><option value="">{{ __('research_projects.select_member') }}</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ app()->getLocale() == "th" ? $u->fname_th." ".$u->lname_th : $u->fname_en." ".$u->lname_en }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>');
            $("#selUser" + i).select2();
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        // โหลดสมาชิกภายนอกจาก $researchProject->users (หรือแยกตามเงื่อนไขถ้ามี)
        var users = <?php echo json_encode($researchProject->users ?? []); ?>;
        var i = 0;

        for (i = 0; i < users.length; i++) {
            var user = users[i];
            // ตัวอย่างเงื่อนไขแยกสมาชิกภายนอก (ปรับตาม logic ของคุณ เช่น role หรือ flag)
            if (user.pivot && user.pivot.role === 3) { // ตัวอย่าง: role 3 หมายถึงภายนอก
                $("#dynamic_field").append('<tr id="row' + i + '" class="dynamic-added"><td><select id="selOutsider' + i + '" name="outsiderFields[' + i + '][userid]" style="width: 200px;" class="my-select"><option value="">{{ __('research_projects.select_member') }}</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ app()->getLocale() == "th" ? $u->fname_th." ".$u->lname_th : $u->fname_en." ".$u->lname_en }}</option>@endforeach</select></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td></tr>');
                document.getElementById("selOutsider" + i).value = user.id;
                $("#selOutsider" + i).select2();
            }
        }

        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><select id="selOutsider' + i + '" name="outsiderFields[' + i + '][userid]" style="width: 200px;" class="my-select"><option value="">{{ __('research_projects.select_member') }}</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ app()->getLocale() == "th" ? $u->fname_th." ".$u->lname_th : $u->fname_en." ".$u->lname_en }}</option>@endforeach</select></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td></tr>');
            $("#selOutsider" + i).select2();
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
@stop
