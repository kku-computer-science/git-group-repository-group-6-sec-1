@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('research_projects.add_button')) {{-- หรือใช้คีย์ที่เหมาะสมสำหรับหน้า create --}}

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
            <h4 class="card-title">{{ __('research_projects.add_fund_title') }}</h4>
            <p class="card-description">{{ __('research_projects.edit_description') }}</p>
            <form action="{{ route('researchProjects.store') }}" method="POST">
                @csrf
                <div class="form-group row mt-5">
                    <label class="col-sm-2">{{ __('research_projects.label.project_name') }}</label>
                    <div class="col-sm-8">
                        <input type="text" name="project_name" class="form-control" placeholder="{{ __('research_projects.placeholder.project_name') }}" value="{{ old('project_name') }}">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_start') }}</label>
                    <div class="col-sm-4">
                        <input type="date" name="project_start" id="Project_start" class="form-control" value="{{ old('project_start') }}">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_end') }}</label>
                    <div class="col-sm-4">
                        <input type="date" name="project_end" id="Project_end" class="form-control" value="{{ old('project_end') }}">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.fund_source') }}</label>
                    <div class="col-sm-4">
                        <select id="fund" style="width: 200px;" class="custom-select my-select" name="fund" required>
                            <option value="" disabled selected>{{ __('research_projects.select_fund') }}</option>
                            @foreach($funds as $fund)
                                <option value="{{ $fund->id }}">{{ $fund->fund_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.year') }}</label>
                    <div class="col-sm-4">
                        <input type="text" name="project_year" class="form-control" placeholder="{{ __('research_projects.year') }}" value="{{ old('project_year') }}">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.budget') }}</label>
                    <div class="col-sm-4">
                        <input type="number" name="budget" class="form-control" placeholder="{{ __('research_projects.label.budget') }}" value="{{ old('budget') }}">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.support_resource') }}</label>
                    <div class="col-sm-9">
                        <select id="dep" style="width: 200px;" class="custom-select my-select" name="responsible_department">
                            <option value="" disabled selected>{{ __('research_projects.select_fund') }}</option>
                            @foreach($deps as $dep)
                                <option value="{{ $dep->department_name_th }}">{{ $dep->department_name_th }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_note') }}</label>
                    <div class="col-sm-9">
                        <textarea name="note" class="form-control form-control-lg" style="height:150px" placeholder="Note">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_status') }}</label>
                    <div class="col-sm-3">
                        <select id="status" class="custom-select my-select" name="status">
                            <option value="" disabled selected>{{ __('research_projects.select_status') }}</option>
                            <option value="1">ยื่นขอ</option>
                            <option value="2">ดำเนินการ</option>
                            <option value="3">ปิดโครงการ</option>
                        </select>
                    </div>
                </div>
                <!-- ส่วนของผู้รับผิดชอบโครงการ (ภายใน) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_head') }}</label>
                    <div class="col-sm-9">
                        <select id="head0" style="width: 200px;" name="head">
                            <option value="">{{ __('research_projects.select_member') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- ส่วนของผู้รับผิดชอบโครงการ (ร่วม) ภายใน -->
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_member') }} ({{ __('research_projects.label.project_member_within') }})</label>
                    <div class="col-sm-9">
                        <table class="table" id="dynamicAddRemove">
                            <tr>
                                <th>
                                    <button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add">
                                        <i class="mdi mdi-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select id="selUser0" style="width: 200px;" name="moreFields[0][userid]">
                                        <option value="">{{ __('research_projects.select_member') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- ส่วนของผู้รับผิดชอบโครงการ (ร่วม) ภายนอก -->
                <div class="form-group row mt-2">
                    <label class="col-sm-2">{{ __('research_projects.label.project_member') }} ({{ __('research_projects.label.project_member_outside') }})</label>
                    <div class="col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-hover small-text" id="tb">
                                <tr class="tr-header">
                                    <th>{{ __('research_projects.label.outsider_title') }}</th>
                                    <th>{{ __('research_projects.label.outsider_fname') }}</th>
                                    <th>{{ __('research_projects.label.outsider_lname') }}</th>
                                    <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore2" title="{{ __('research_projects.label.add_more') }}"><i class="mdi mdi-plus"></i></a></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="title_name[]" class="form-control" placeholder="{{ __('research_projects.placeholder.outsider_title') }}"></td>
                                    <td><input type="text" name="fname[]" class="form-control" placeholder="{{ __('research_projects.placeholder.outsider_fname') }}"></td>
                                    <td><input type="text" name="lname[]" class="form-control" placeholder="{{ __('research_projects.placeholder.outsider_lname') }}"></td>
                                    <td><a href='javascript:void(0);' class='remove'><span><i class="mdi mdi-minus"></i></span></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ __('research_projects.submit_button') }}</button>
                    <a class="btn btn-light" href="{{ route('researchProjects.index') }}">{{ __('research_projects.back_button') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script>
    $(document).ready(function() {
        $("#selUser0").select2();
        $("#head0").select2();
        var i = 0;
        // เก็บตัวเลือกสำหรับ select dropdown ใน dynamic field
        var selectOptions = `
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}
                </option>
            @endforeach
        `;

        $("#add-btn2").click(function() {
            ++i;
            var newRow = `
                <tr>
                    <td>
                        <select id="selUser${i}" name="moreFields[${i}][userid]" style="width: 200px;">
                            <option value="">{{ __('research_projects.select_member') }}</option>
                            ${selectOptions}
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-tr">
                            <i class="mdi mdi-minus"></i>
                        </button>
                    </td>
                </tr>
            `;
            $("#dynamicAddRemove").append(newRow);
            $("#selUser" + i).select2();
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@stop

