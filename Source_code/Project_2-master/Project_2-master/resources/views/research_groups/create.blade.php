@extends('dashboards.users.layouts.user-dash-layout')

<<<<<<< HEAD
@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">สร้างกลุ่มวิจัย</h4>
            <p class="card-description">กรอกข้อมูลแก้ไขรายละเอียดกลุ่มวิจัย</p>
            <form action="{{ route('researchGroups.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <p class="col-sm-3 "><b>ชื่อกลุ่มวิจัย (ภาษาไทย)</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_th" value="{{ old('group_name_th') }}" class="form-control"
                            placeholder="ชื่อกลุ่มวิจัย (ภาษาไทย)">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>ชื่อกลุ่มวิจัย (English)</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_en" value="{{ old('group_name_en') }}" class="form-control"
                            placeholder="ชื่อกลุ่มวิจัย (English)">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>คำอธิบายกลุ่มวิจัย (ภาษาไทย)</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_th" value="{{ old('group_desc_th') }}" class="form-control"
                            style="height:90px"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>คำอธิบายกลุ่มวิจัย (English)</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_en" value="{{ old('group_desc_en') }}" class="form-control"
                            style="height:90px"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>รายละเอียดกลุ่มวิจัย (ภาษาไทย)</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_en" value="{{ old('group_detail_th') }}" class="form-control"
                            style="height:90px"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>รายละเอียดกลุ่มวิจัย (English)</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_en" value="{{ old('group_detail_en') }}" class="form-control"
                            style="height:90px"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>image</b></p>
                    <div class="col-sm-8">
                        <input type="file" name="group_image" class="form-control" value="{{ old('group_image') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>หัวหน้ากลุ่มวิจัย</b></p>
                    <div class="col-sm-8">
                        <select id='head0' name="head">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->fname_th }} {{ $user->lname_th }}
                            </option>
=======
@section('title', __('research_groups.add_fund_title'))

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('research_groups.confirm_title') }}</strong> {{ __('research_groups.confirm_text') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card col-md-12" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('research_groups.add_fund_title') }}</h4>
            <p class="card-description">{{ __('research_groups.edit_description') }}</p>
            <form action="{{ route('researchGroups.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Group Name (Thai) -->
                <div class="form-group row">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_name_th') }}</b></label>
                    <div class="col-sm-8">
                        <input type="text" name="group_name_th" class="form-control" placeholder="{{ __('research_groups.placeholder.group_name_th') }}" value="{{ old('group_name_th') }}">
                    </div>
                </div>
                <!-- Group Name (English) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_name_en') }}</b></label>
                    <div class="col-sm-8">
                        <input type="text" name="group_name_en" class="form-control" placeholder="{{ __('research_groups.placeholder.group_name_en') }}" value="{{ old('group_name_en') }}">
                    </div>
                </div>
                <!-- Group Description (Thai) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_desc_th') }}</b></label>
                    <div class="col-sm-8">
                        <textarea name="group_desc_th" class="form-control" style="height:90px" placeholder="{{ __('research_groups.placeholder.group_desc_th') }}">{{ old('group_desc_th') }}</textarea>
                    </div>
                </div>
                <!-- Group Description (English) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_desc_en') }}</b></label>
                    <div class="col-sm-8">
                        <textarea name="group_desc_en" class="form-control" style="height:90px" placeholder="{{ __('research_groups.placeholder.group_desc_en') }}">{{ old('group_desc_en') }}</textarea>
                    </div>
                </div>
                <!-- Group Detail (Thai) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_detail_th') }}</b></label>
                    <div class="col-sm-8">
                        <textarea name="group_detail_th" class="form-control" style="height:90px" placeholder="{{ __('research_groups.placeholder.group_detail_th') }}">{{ old('group_detail_th') }}</textarea>
                    </div>
                </div>
                <!-- Group Detail (English) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_detail_en') }}</b></label>
                    <div class="col-sm-8">
                        <textarea name="group_detail_en" class="form-control" style="height:90px" placeholder="{{ __('research_groups.placeholder.group_detail_en') }}">{{ old('group_detail_en') }}</textarea>
                    </div>
                </div>
                <!-- Group Image -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_image') }}</b></label>
                    <div class="col-sm-8">
                        <input type="file" name="group_image" class="form-control">
                    </div>
                </div>
                <!-- Group Head -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_head') }}</b></label>
                    <div class="col-sm-8">
                        <select id="head0" class="custom-select" name="head">
                            <option value="">{{ __('research_groups.select_member') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}
                                </option>
>>>>>>> origin/Prommin_1406
                            @endforeach
                        </select>
                    </div>
                </div>
<<<<<<< HEAD
                <div class="form-group row">
                    <p class="col-sm-3 pt-4"><b>สมาชิกกลุ่มวิจัย</b></p>
                    <div class="col-sm-8">
                        <table class="table" id="dynamicAddRemove">
                            <tr>
                                <th><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add"><i
                                            class="mdi mdi-plus"></i></button></th>
=======
                <!-- Group Members (Internal) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_member') }} ({{ __('research_groups.label.project_member_within') }})</b></label>
                    <div class="col-sm-8">
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
                                    <select id="selUser0" class="custom-select" style="width: 200px;" name="moreFields[0][userid]">
                                        <option value="">{{ __('research_groups.select_member') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
>>>>>>> origin/Prommin_1406
                            </tr>
                        </table>
                    </div>
                </div>
<<<<<<< HEAD
                <button type="submit" class="btn btn-primary upload mt-5">Submit</button>
                <a class="btn btn-light mt-5" href="{{ route('researchGroups.index')}}"> Back</a>
                </form>
        </div>
    </div>
</div>

@stop
@section('javascript')
<!-- <script type="text/javascript">
$("body").on("click",".upload",function(e){
    $(this).parents("form").ajaxForm(options);
  });


  var options = { 
    complete: function(response) 
    {
        if($.isEmptyObject(response.responseJSON.error)){
            // $("input[name='title']").val('');
            // alert('Image Upload Successfully.');
        }else{
            printErrorMsg(response.responseJSON.error);
        }
    }
  };


  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
  }
</script> -->
<script>
$(document).ready(function() {
    $("#selUser0").select2()
    $("#head0").select2()

    var i = 0;

    $("#add-btn2").click(function() {

        ++i;
        $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
            '][userid]"  style="width: 200px;"><option value="">Select User</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="fas fa-minus"></i></button></td></tr>'
            );
        $("#selUser" + i).select2()
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });

});
</script>
@stop
=======
                <!-- Group Members (External) -->
                <div class="form-group row mt-2">
                    <label class="col-sm-3"><b>{{ __('research_groups.label.group_member') }} ({{ __('research_groups.label.project_member_outside') }})</b></label>
                    <div class="col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-hover small-text" id="tb">
                                <tr class="tr-header">
                                    <th>{{ __('research_groups.label.outsider_title') }}</th>
                                    <th>{{ __('research_groups.label.outsider_fname') }}</th>
                                    <th>{{ __('research_groups.label.outsider_lname') }}</th>
                                    <th>
                                        <a href="javascript:void(0);" id="addMore2" style="font-size:18px;" title="{{ __('research_groups.label.add_more') }}">
                                            <i class="mdi mdi-plus"></i>
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="title_name[]" class="form-control" placeholder="{{ __('research_groups.placeholder.outsider_title') }}">
                                    </td>
                                    <td>
                                        <input type="text" name="fname[]" class="form-control" placeholder="{{ __('research_groups.placeholder.outsider_fname') }}">
                                    </td>
                                    <td>
                                        <input type="text" name="lname[]" class="form-control" placeholder="{{ __('research_groups.placeholder.outsider_lname') }}">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="remove">
                                            <i class="mdi mdi-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-primary upload mt-5">{{ __('research_groups.submit_button') }}</button>
                    <a class="btn btn-light mt-5" href="{{ route('researchGroups.index') }}">{{ __('research_groups.back_button') }}</a>
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
                        <option value="">{{ __('research_groups.select_member') }}</option>
                        ${selectOptions}
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button>
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
<script>
$(document).ready(function() {
    var i = 0;
    $('#addMore2').click(function() {
        i++;
        $('#tb').append(`
            <tr id="row${i}" class="dynamic-added">
                <td><input type="text" name="title_name[]" placeholder="{{ __('research_groups.placeholder.outsider_title') }}" style="width: 200px;" class="form-control" /></td>
                <td><input type="text" name="fname[]" placeholder="{{ __('research_groups.placeholder.outsider_fname') }}" style="width: 300px;" class="form-control" /></td>
                <td><input type="text" name="lname[]" placeholder="{{ __('research_groups.placeholder.outsider_lname') }}" style="width: 300px;" class="form-control" /></td>
                <td><button type="button" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td>
            </tr>
        `);
    });
    $(document).on('click', '.btn_remove', function() {
        $(this).closest('tr').remove();
    });
});
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@stop
>>>>>>> origin/Prommin_1406
