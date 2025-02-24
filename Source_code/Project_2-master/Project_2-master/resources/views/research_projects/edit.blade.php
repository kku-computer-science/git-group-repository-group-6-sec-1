@extends('dashboards.users.layouts.user-dash-layout')
<<<<<<< HEAD
=======

@section('title', __('research_projects.edit_title'))

>>>>>>> origin/Prommin_1406
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
<<<<<<< HEAD
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
=======
        <strong>{{ __('research_projects.confirm_title') }}</strong> {{ __('research_projects.confirm_text') }}<br><br>
>>>>>>> origin/Prommin_1406
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card col-md-12" style="padding: 16px;">
        <div class="card-body">
<<<<<<< HEAD
            <h4 class="card-title">แก้ไขข้อมูลโครงการวิจัย</h4>
            <p class="card-description">กรอกข้อมูลแก้ไขรายละเอียดโครงการวิจัย</p>
            <form action="{{ route('researchProjects.update',$researchProject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-3 "><b>ชื่อโครงการ</b></p>
                    <div class="col-sm-8">
                        <textarea name="project_name" value="{{ $researchProject->project_name }}" class="form-control" style="height:90px">{{ $researchProject->project_name }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>วันเริ่มต้นโครงการ</b></p>
=======
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
>>>>>>> origin/Prommin_1406
                    <div class="col-sm-4">
                        <input type="date" name="project_start" value="{{ $researchProject->project_start }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
<<<<<<< HEAD
                    <p class="col-sm-3 "><b>วันสิ้นสุดโครงการ</b></p>
=======
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_end') }}</b></p>
>>>>>>> origin/Prommin_1406
                    <div class="col-sm-4">
                        <input type="date" name="project_end" value="{{ $researchProject->project_end }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
<<<<<<< HEAD
                    <p for="exampleInputfund_details" class="col-sm-3"><b>เลือกทุน</b></p>
                    <div class="col-sm-9">
                        <select id='fund' style='width: 200px;' class="custom-select my-select" name="fund">
                            <option value='' disabled selected>เลือกทุนวิจัย</option>@foreach($funds as $f)<option value="{{ $f->id }}" {{ $f->fund_name == $researchProject->fund->fund_name ? 'selected' : '' }}>{{ $f->fund_name }}</option>
=======
                    <p class="col-sm-3"><b>{{ __('research_projects.label.fund_source') }}</b></p>
                    <div class="col-sm-9">
                        <select id="fund" style="width: 200px;" class="custom-select my-select" name="fund">
                            <option value="" disabled selected>{{ __('research_projects.select_fund') }}</option>
                            @foreach($funds as $f)
                                <option value="{{ $f->id }}" {{ $f->fund_name == $researchProject->fund->fund_name ? 'selected' : '' }}>
                                    {{ $f->fund_name }}
                                </option>
>>>>>>> origin/Prommin_1406
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2">
<<<<<<< HEAD
                    <p class="col-sm-3 "><b>ปีที่ยื่น (ค.ศ.)</b></p>
                    <div class="col-sm-8">
                        <input type="year" name="project_year" class="form-control" placeholder="ปี" value="{{$researchProject->project_year}}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>งบประมาณ</b></p>
=======
                    <p class="col-sm-3"><b>{{ __('research_projects.year') }}</b></p>
                    <div class="col-sm-8">
                        <input type="year" name="project_year" class="form-control" placeholder="{{ __('research_projects.year') }}" value="{{ $researchProject->project_year }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.budget') }}</b></p>
>>>>>>> origin/Prommin_1406
                    <div class="col-sm-4">
                        <input type="number" name="budget" value="{{ $researchProject->budget }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
<<<<<<< HEAD
                    <p class="col-sm-3 "><b>หน่วยงานที่รับผิดชอบ</b></p>
                    <div class="col-sm-3">
                        <select id='dep' style='width: 200px;' class="custom-select my-select"  name="responsible_department">
                            <option value=''>เลือกสาขาวิชา</option>@foreach($deps as $dep)<option value="{{ $dep->department_name_th }}" {{ $dep->department_name_th == $researchProject->responsible_department ? 'selected' : '' }}>{{ $dep->department_name_th }}</option>@endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <p class="col-sm-3 "><b>รายละเอียดโครงการวิจัย</b></p>
=======
                    <p class="col-sm-3"><b>{{ __('research_projects.label.support_resource') }}</b></p>
                    <div class="col-sm-8">
                        <input type="text" name="responsible_department" class="form-control" placeholder="{{ __('research_projects.placeholder.support_resource') }}" value="{{ $researchProject->responsible_department }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_note') }}</b></p>
>>>>>>> origin/Prommin_1406
                    <div class="col-sm-8">
                        <textarea name="note" class="form-control" style="height:90px">{{ $researchProject->note }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
<<<<<<< HEAD
                    <p class="col-sm-3 "><b>สถานะ</b></p>
                    <div class="col-sm-8">
                        <select id='status' class="custom-select my-select" style='width: 200px;' name="status">
                            <option value="1" {{ 1 == $researchProject->status ? 'selected' : '' }}>ยื่นขอ</option>
                            <option value="2" {{ 2 == $researchProject->status ? 'selected' : '' }}>ดำเนินการ</option>
                            <option value="3" {{ 3 == $researchProject->status ? 'selected' : '' }}>ปิดโครงการ</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table">
                        <tr>
                            <th>ผู้รับผิดชอบโครงการ</th>
                        <tr>
                            <td>
                                <select id='head0' style='width: 200px;' name="head">
                                    @foreach($researchProject->user as $u)
                                    @if($u->pivot->role == 1)
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($u->id == $user->id) selected @endif>
                                        {{ $user->fname_th }} {{ $user->lname_th }}
                                    </option>
                                    @endforeach
                                    @endif
=======
                    <p class="col-sm-3"><b>{{ __('research_projects.label.project_status') }}</b></p>
                    <div class="col-sm-8">
                        <select id="status" class="custom-select my-select" style="width: 200px;" name="status">
                            <option value="1" {{ 1 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.submitted') }}</option>
                            <option value="2" {{ 2 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.in_progress') }}</option>
                            <option value="3" {{ 3 == $researchProject->status ? 'selected' : '' }}>{{ __('research_projects.status.closed') }}</option>
                        </select>
                    </div>
                </div>
                <!-- ส่วนการจัดการผู้รับผิดชอบและสมาชิกคงไว้ตามเดิม -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table">
                        <tr>
                            <th>{{ __('research_projects.label.project_head') }}</th>
                        <tr>
                            <td>
                                <select id="head0" style="width: 200px;" name="head">
                                    @foreach($researchProject->user as $u)
                                        @if($u->pivot->role == 1)
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if($u->id == $user->id) selected @endif>
                                                    {{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}
                                                </option>
                                            @endforeach
                                        @endif
>>>>>>> origin/Prommin_1406
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
<<<<<<< HEAD
                    <table class="table " id="dynamicAddRemove">
                        <tr>
                            <th width="522.98px">ผู้รับผิดชอบโครงการ (ร่วม) ภายใน</th>
=======
                    <table class="table" id="dynamicAddRemove">
                        <tr>
                        <th width="522.98px">
                            {{ __('research_projects.label.project_member') }} 
                            ({{ __('research_projects.label.project_member_within') }})
                        </th>

>>>>>>> origin/Prommin_1406
                            <th><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add"><i class="mdi mdi-plus"></i></button></th>
                        </tr>
                    </table>
                </div>
                <div class="form-group row">
<<<<<<< HEAD
                        <label for="exampleInputpaper_author" class="col-sm-3 col-form-label">ผู้รับผิดชอบโครงการ (ร่วม) ภายนอก</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-bordered w-75" id="dynamic_field">

                                    <tr>
                                        <td><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button>
                                        </td>
                                    </tr>

                                </table>
                                <!-- <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" /> -->
                            </div>
                        </div>
                        </div>
                <button type="submit" class="btn btn-primary mt-5">Submit</button>
                <a class="btn btn-light mt-5" href="{{ route('researchProjects.index') }}"> Back</a>
=======
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
>>>>>>> origin/Prommin_1406
            </form>
        </div>
    </div>
</div>
@stop
<<<<<<< HEAD
=======

>>>>>>> origin/Prommin_1406
@section('javascript')
<script>
    $(document).ready(function() {

<<<<<<< HEAD
        $("#head0").select2()
        //$("#fund").select2()

        //$("#dep").select2()
=======
        $("#head0").select2();

>>>>>>> origin/Prommin_1406
        var researchProject = <?php echo $researchProject['user']; ?>;
        var i = 0;

        for (i = 0; i < researchProject.length; i++) {
            var obj = researchProject[i];

            if (obj.pivot.role === 2) {
                $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
<<<<<<< HEAD
                    '][userid]"  style="width: 200px;">@foreach($users as $user)<option value="{{ $user->id }}" >{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
                );
                document.getElementById("selUser" + i).value = obj.id;
                $("#selUser" + i).select2()

            }
            //document.getElementById("#dynamicAddRemove").value = "10";
        }


        $("#add-btn2").click(function() {

            ++i;
            $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                '][userid]"  style="width: 200px;"><option value="">Select User</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
            );
            $("#selUser" + i).select2()
        });


        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

=======
                    '][userid]"  style="width: 200px;">@foreach($users as $user)<option value="{{ $user->id }}">{{ app()->getLocale() == "th" ? $user->fname_th." ".$user->lname_th : $user->fname_en." ".$user->lname_en }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
                );
                document.getElementById("selUser" + i).value = obj.id;
                $("#selUser" + i).select2();
            }
        }

        $("#add-btn2").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                '][userid]"  style="width: 200px;"><option value="">{{ __('research_projects.select_member') }}</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ app()->getLocale() == "th" ? $user->fname_th." ".$user->lname_th : $user->fname_en." ".$user->lname_en }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
            );
            $("#selUser" + i).select2();
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
>>>>>>> origin/Prommin_1406
    });
</script>
<script>
    $(document).ready(function() {
        var outsider = <?php echo $researchProject->outsider; ?>;
<<<<<<< HEAD

        var postURL = "<?php echo url('addmore'); ?>";
        var i = 0;
        //console.log(patent)

        for (i = 0; i < outsider.length; i++) {value="'+ obj.title_name +'"
            //console.log(patent);
            var obj = outsider[i];
            $("#dynamic_field").append('<tr id="row' + i +
                '" class="dynamic-added"><td><p>ตำแหน่งหรือคำนำหน้า :</p><input type="text" name="title_name[]" value="'+ obj.title_name +'" placeholder="ตำแหน่งหรือคำนำหน้า" style="width: 200px;" class="form-control name_list" /><br><p>ชื่อ :</p><input type="text" name="fname[]" value="'+ obj.fname +'" placeholder="ชื่อ" style="width: 300px;" class="form-control name_list" /><br><p>นามสกุล :</p><input type="text" name="lname[]" value="'+ obj.lname +'" placeholder="นามสกุล" style="width: 300px;" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td></tr>');
            //document.getElementById("selUser" + i).value = obj.id;
            //console.log(obj.author_fname)
            // let doc=document.getElementById("row" + i)
            // doc.setAttribute('fname','aaa');
            // doc.setAttribute('lname','bbb');
            //document.getElementById("row" + i).value = obj.author_lname;
            //document.getAttribute("lname").value = obj.author_lname;
            //$("#selUser" + i).select2()


            //document.getElementById("#dynamicAddRemove").value = "10";
=======
        var i = 0;
        for (i = 0; i < outsider.length; i++) {
            var obj = outsider[i];
            $("#dynamic_field").append('<tr id="row' + i +
                '" class="dynamic-added"><td><p>{{ __('research_projects.label.outsider_title') }} :</p><input type="text" name="title_name[]" value="'+ obj.title_name +'" placeholder="{{ __('research_projects.placeholder.outsider_title') }}" style="width: 200px;" class="form-control name_list" /><br><p>{{ __('research_projects.label.outsider_fname') }} :</p><input type="text" name="fname[]" value="'+ obj.fname +'" placeholder="{{ __('research_projects.placeholder.outsider_fname') }}" style="width: 300px;" class="form-control name_list" /><br><p>{{ __('research_projects.label.outsider_lname') }} :</p><input type="text" name="lname[]" value="'+ obj.lname +'" placeholder="{{ __('research_projects.placeholder.outsider_lname') }}" style="width: 300px;" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td></tr>');
>>>>>>> origin/Prommin_1406
        }

        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
<<<<<<< HEAD
                '" class="dynamic-added"><td><p>ตำแหน่งหรือคำนำหน้า :</p><input type="text" name="title_name[]" placeholder="ตำแหน่งหรือคำนำหน้า" style="width: 200px;" class="form-control name_list" /><br><p>ชื่อ :</p><input type="text" name="fname[]" placeholder="ชื่อ" style="width: 300px;" class="form-control name_list" /><br><p>นามสกุล :</p><input type="text" name="lname[]" placeholder="นามสกุล" style="width: 300px;" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
=======
                '" class="dynamic-added"><td><p>{{ __('research_projects.label.outsider_title') }} :</p><input type="text" name="title_name[]" placeholder="{{ __('research_projects.placeholder.outsider_title') }}" style="width: 200px;" class="form-control name_list" /><br><p>{{ __('research_projects.label.outsider_fname') }} :</p><input type="text" name="fname[]" placeholder="{{ __('research_projects.placeholder.outsider_fname') }}" style="width: 300px;" class="form-control name_list" /><br><p>{{ __('research_projects.label.outsider_lname') }} :</p><input type="text" name="lname[]" placeholder="{{ __('research_projects.placeholder.outsider_lname') }}" style="width: 300px;" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
>>>>>>> origin/Prommin_1406
                i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
<<<<<<< HEAD

    });
</script>
@stop
=======
    });
</script>
@stop
>>>>>>> origin/Prommin_1406
