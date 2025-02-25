@extends('dashboards.users.layouts.user-dash-layout')
<style>
    body label:not(.input-group-text) {
        margin-top: 10px;
    }

    body .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 6px 20px;
        width: 100%;
    }
</style>
@section('title', trans('reference.profile'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
@section('content')
<div class="container profile">
    <div class="bg-white shadow rounded-lg d-block d-sm-flex">
        <div class="profile-tab-nav border-right">
            <div class="p-4">
                <div class="img-circle text-center mb-3">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle admin_picture" src="{{ Auth::user()->picture }}" alt="{{ trans('reference.profile') }} picture">
                    </div>
                    <h4 class="text-center p-2">{{ Auth::user()->{'fname_'.app()->getLocale()} }} {{ Auth::user()->{'lname_'.app()->getLocale()} }}</h4>
                    <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block btn-sm" id="change_picture_btn"><b>{{ trans('reference.change_picture') }}</b></a>
                </div>
            </div>
            <div class="nav flex-column nav-pills-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                    <i class="mdi mdi-account-card-details"></i>
                    <span class="menu-title">{{ trans('reference.account') }}</span>
                </a>
                <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                    <i class="mdi mdi-key-variant"></i>
                    <span class="menu-title">{{ trans('reference.password') }}</span>
                </a>
                @if(Auth::user()->hasRole('teacher'))
                <a class="nav-link {{ old('tab') == 'expertise' ? ' active' : null }}" id="expertise-tab" data-toggle="pill" href="#expertise" role="tab" aria-controls="expertise" aria-selected="false">
                    <i class="mdi mdi-account-star"></i>
                    <span class="menu-title">{{ trans('reference.expertise') }}</span>
                </a>
                <a class="nav-link" id="education-tab" data-toggle="pill" href="#education" role="tab" aria-controls="education" aria-selected="false">
                    <i class="mdi mdi-school"></i>
                    <span class="menu-title">{{ trans('reference.education') }}</span>
                </a>
                @endif
            </div>
        </div>
        <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
            <div class="tab-pane" id="account" role="tabpanel" aria-labelledby="account-tab">
                <h3 class="mb-4">{{ trans('reference.profile_settings') }}</h3>
                <form class="form-horizontal" method="POST" action="{{ route('adminUpdateInfo') }}" id="AdminInfoForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-sm-4">
                                <label>{{ trans('reference.name_title') }}</label>
                                <select class="custom-select my-select" name="title_name_en">
                                    <option value="Mr." {{ Auth::user()->title_name_en == 'Mr.' ? 'selected' : '' }}>{{ trans('reference.mr') }}</option>
                                    <option value="Miss" {{ Auth::user()->title_name_en == 'Miss' ? 'selected' : '' }}>{{ trans('reference.miss') }}</option>
                                    <option value="Mrs." {{ Auth::user()->title_name_en == 'Mrs.' ? 'selected' : '' }}>{{ trans('reference.mrs') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.first_name_en') }}</label>
                                <input type="text" class="form-control" id="inputfNameEN" placeholder="{{ trans('reference.name') }}" value="{{ Auth::user()->fname_en }}" name="fname_en">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.last_name_en') }}</label>
                                <input type="text" class="form-control" id="inputlNameEN" placeholder="{{ trans('reference.name') }}" value="{{ Auth::user()->lname_en }}" name="lname_en">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.first_name_th') }}</label>
                                <input type="text" class="form-control" id="inputfNameTH" placeholder="{{ trans('reference.name') }}" value="{{ Auth::user()->fname_th }}" name="fname_th">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.last_name_th') }}</label>
                                <input type="text" class="form-control" id="inputlNameTH" placeholder="{{ trans('reference.name') }}" value="{{ Auth::user()->lname_th }}" name="lname_th">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.email') }}</label>
                                <input type="text" class="form-control" id="inputEmail" placeholder="{{ trans('reference.email') }}" value="{{ Auth::user()->email }}" name="email">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        @if(Auth::user()->hasRole('teacher'))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.academic_ranks') }}</label>
                                <select id="category" class="custom-select my-select" name="academic_ranks_en">
                                    <option value="Professor" {{ Auth::user()->academic_ranks_en == 'Professor' ? 'selected' : '' }}>{{ trans('reference.professor') }}</option>
                                    <option value="Associate Professor" {{ Auth::user()->academic_ranks_en == 'Associate Professor' ? 'selected' : '' }}>{{ trans('reference.associate_professor') }}</option>
                                    <option value="Assistant Professor" {{ Auth::user()->academic_ranks_en == 'Assistant Professor' ? 'selected' : '' }}>{{ trans('reference.assistant_professor') }}</option>
                                    <option value="Lecturer" {{ Auth::user()->academic_ranks_en == 'Lecturer' ? 'selected' : '' }}>{{ trans('reference.lecturer') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.academic_ranks_th') }}</label>
                                <select name="academic_ranks_th" id="subcategory" class="custom-select my-select">
                                    <optgroup id="Professor" label="{{ trans('reference.professor') }}">
                                        <option value="ศาสตราจารย์" {{ Auth::user()->academic_ranks_th == 'ศาสตราจารย์' ? 'selected' : '' }}>{{ trans('reference.professor_th') }}</option>
                                    </optgroup>
                                    <optgroup id="Associate Professor" label="{{ trans('reference.associate_professor') }}">
                                        <option value="รองศาสตราจารย์" {{ Auth::user()->academic_ranks_th == 'รองศาสตราจารย์' ? 'selected' : '' }}>{{ trans('reference.associate_professor_th') }}</option>
                                    </optgroup>
                                    <optgroup id="Assistant Professor" label="{{ trans('reference.assistant_professor') }}">
                                        <option value="ผู้ช่วยศาสตราจารย์" {{ Auth::user()->academic_ranks_th == 'ผู้ช่วยศาสตราจารย์' ? 'selected' : '' }}>{{ trans('reference.assistant_professor_th') }}</option>
                                    </optgroup>
                                    <optgroup id="Lecturer" label="{{ trans('reference.lecturer') }}">
                                        <option value="อาจารย์" {{ Auth::user()->academic_ranks_th == 'อาจารย์' ? 'selected' : '' }}>{{ trans('reference.lecturer_th') }}</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input name="pos" type="checkbox" value="check2" />{{ trans('reference.no_phd_note') }}</label>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">{{ trans('reference.update') }}</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form class="form-horizontal" action="{{ route('adminChangePassword') }}" method="POST" id="changePasswordAdminForm">
                    <h3 class="mb-4">{{ trans('reference.password_settings') }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.old_password') }}</label>
                                <input type="password" class="form-control" id="inputpassword" placeholder="{{ trans('reference.enter_current_password') }}" name="oldpassword">
                                <span class="text-danger error-text oldpassword_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.new_password') }}</label>
                                <input type="password" class="form-control" id="newpassword" placeholder="{{ trans('reference.enter_new_password') }}" name="newpassword">
                                <span class="text-danger error-text newpassword_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('reference.confirm_new_password') }}</label>
                                <input type="password" class="form-control" id="cnewpassword" placeholder="{{ trans('reference.reenter_new_password') }}" name="cnewpassword">
                                <span class="text-danger error-text cnewpassword_error"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">{{ trans('reference.update') }}</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                <form class="form-horizontal" method="POST" action="{{ route('updateEdInfo') }}" id="EdInfoForm">
                    <h3 class="mb-4">{{ trans('reference.educational_history') }}</h3>
                    <div class="row">
                        <label>{{ trans('reference.bachelor_degree') }}</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.university_name') }}</label>
                                @if (empty(Auth::user()->education[0]->uname))
                                <input type="text" class="form-control" id="inputlBUName" placeholder="{{ trans('reference.university_name') }}" value="" name="b_uname">
                                @else
                                <input type="text" class="form-control" id="inputlBUName" placeholder="{{ trans('reference.university_name') }}" value="{{ Auth::user()->education[0]->uname }}" name="b_uname">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.degree_name') }}</label>
                                @if (empty(Auth::user()->education[0]->qua_name))
                                <input type="text" class="form-control" id="inputlBQuName" placeholder="{{ trans('reference.degree_name') }}" value="" name="b_qua_name">
                                @else
                                <input type="text" class="form-control" id="inputlBQuName" placeholder="{{ trans('reference.degree_name') }}" value="{{ Auth::user()->education[0]->qua_name }}" name="b_qua_name">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.graduation_year') }}</label>
                                @if (empty(Auth::user()->education[0]->year))
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="" name="b_year">
                                @else
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="{{ Auth::user()->education[0]->year }}" name="b_year">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label>{{ trans('reference.masters_degree') }}</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.university_name') }}</label>
                                @if (empty(Auth::user()->education[1]->uname))
                                <input type="text" class="form-control" id="inputlMUName" placeholder="{{ trans('reference.university_name') }}" value="" name="m_uname">
                                @else
                                <input type="text" class="form-control" id="inputlMUName" placeholder="{{ trans('reference.university_name') }}" value="{{ Auth::user()->education[1]->uname }}" name="m_uname">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.degree_name') }}</label>
                                @if (empty(Auth::user()->education[1]->qua_name))
                                <input type="text" class="form-control" id="inputlMQuName" placeholder="{{ trans('reference.degree_name') }}" value="" name="m_qua_name">
                                @else
                                <input type="text" class="form-control" id="inputlMQuName" placeholder="{{ trans('reference.degree_name') }}" value="{{ Auth::user()->education[1]->qua_name }}" name="m_qua_name">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.graduation_year') }}</label>
                                @if (empty(Auth::user()->education[1]->year))
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="" name="m_year">
                                @else
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="{{ Auth::user()->education[1]->year }}" name="m_year">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label>{{ trans('reference.doctoral_degree') }}</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.university_name') }}</label>
                                @if (empty(Auth::user()->education[2]->uname))
                                <input type="text" class="form-control" id="inputlDUName" placeholder="{{ trans('reference.university_name') }}" value="" name="d_uname">
                                @else
                                <input type="text" class="form-control" id="inputlDUName" placeholder="{{ trans('reference.university_name') }}" value="{{ Auth::user()->education[2]->uname }}" name="d_uname">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.degree_name') }}</label>
                                @if (empty(Auth::user()->education[2]->qua_name))
                                <input type="text" class="form-control" id="inputlDQuName" placeholder="{{ trans('reference.degree_name') }}" value="" name="d_qua_name">
                                @else
                                <input type="text" class="form-control" id="inputlDQuName" placeholder="{{ trans('reference.degree_name') }}" value="{{ Auth::user()->education[2]->qua_name }}" name="d_qua_name">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('reference.graduation_year') }}</label>
                                @if (empty(Auth::user()->education[2]->year))
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="" name="d_year">
                                @else
                                <input type="text" class="form-control" id="inputlYear" placeholder="{{ trans('reference.graduation_year') }}" value="{{ Auth::user()->education[2]->year }}" name="d_year">
                                @endif
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">{{ trans('reference.update') }}</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade show{{ old('tab') == 'expertise' ? ' active' : null }}" id="expertise" role="tabpanel" aria-labelledby="expertise-tab">
                <h3 class="mb-4">{{ trans('reference.expertise_title') }}</h3>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary btn-menu1 btn-icon-text btn-sm mb-3" data-toggle="modal" data-target="#crud-modal">
                                <i class="mdi mdi-plus btn-icon-prepend"></i>{{ trans('reference.add_expertise') }}
                            </button>
                        </div>
                    </div>
                </div>
                <br />
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p id="msg">{{ $message }}</p>
                </div>
                @endif

                <table class="table table-striped table-hover">
                    <tr>
                        <th colspan="2">{{ trans('reference.expertise_title') }}</th>
                    </tr>
                    @foreach (Auth::user()->expertise as $expert)
                    <tr id="expert_id_{{ $expert->id }}">
                        <td>{{ $expert->expert_name }}</td>
                        <td width="180px">
                            <form action="{{ route('experts.destroy', $expert->id) }}" method="POST">
                                <li class="list-inline-item">
                                    <button class="btn btn-outline-success btn-sm" href="javascript:void(0)" id="edit-expertise" type="button" data-toggle="modal" data-placement="top" data-id="{{ $expert->id }}" title="{{ trans('reference.edit') }}"><i class="mdi mdi-pencil"></i></button>
                                </li>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <li class="list-inline-item">
                                    <button id="delete-expertise" data-id="{{ $expert->id }}" class="btn btn-outline-danger btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ trans('reference.delete') }}"><i class="mdi mdi-delete"></i></button>
                                </li>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="expertiseCrudModal">{{ trans('reference.expertise') }}</h4>
            </div>
            <div class="modal-body">
                <form name="expForm" action="{{ route('experts.store') }}" method="POST">
                    <input type="hidden" name="exp_id" id="exp_id">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ trans('reference.name') }}:</strong>
                                <input type="text" name="expert_name" id="expert_name" class="form-control" placeholder="{{ trans('reference.expertise_name') }}" onchange="validate()">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ trans('reference.submit') }}</button>
                            <button class="btn btn-danger" id="btnCancel" data-dismiss="modal">{{ trans('reference.cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var $optgroups = $('#subcategory > optgroup');

        $("#category").on("change", function() {
            var selectedVal = this.value;

            $('#subcategory').html($optgroups.filter('[id="' + selectedVal + '"]'));
        });
    });
</script>

<script>
    $(function() {
        /* UPDATE ADMIN
               PERSONAL INFO */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        showSwal = function(type) {
            swal({
                    title: "{{ trans('reference.confirm_update_info') }}",
                    text: "{{ trans('reference.confirm_proceed') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#82ce34",
                    confirmButtonText: "{{ trans('reference.update_info') }}",
                    cancelButtonText: "{{ trans('reference.not_sure') }}",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal("{{ trans('reference.update_info_success') }}", "{{ trans('reference.account_updated') }}", "success");
                    } else {
                        swal("{{ trans('reference.cancel') }}", "{{ trans('reference.account_not_updated') }}", "error");
                    }
                });
        }

        $('#AdminInfoForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#AdminInfoForm').find($('input[name="name"]')).val());
                        });
                        console.log(data.msg);
                        swal("{{ trans('reference.update_info_success') }}", "{{ trans('reference.account_updated') }}", "success");
                    }
                }
            });
        });

        $('#EdInfoForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#EdInfoForm').find($('input[name="name"]')).val());
                        });
                        console.log(data.msg);
                        swal("{{ trans('reference.update_info_success') }}", "{{ trans('reference.account_updated') }}", "success");
                    }
                }
            });
        });

        $(document).on('click', '#change_picture_btn', function() {
            $('#admin_image').click();
        });
        $('#admin_image').ijaboCropTool({
            preview: '.admin_picture',
            setRatio: 2 / 3,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['{{ trans('reference.crop') }}', '{{ trans('reference.quit') }}'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: '{{ route("adminPictureUpdate") }}',
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                swal("{{ trans('reference.update_picture_success') }}", "{{ trans('reference.account_updated') }}", "success");
            },
            onError: function(message, element, status) {
                alert(message);
            }
        });
        $('#changePasswordAdminForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#changePasswordAdminForm')[0].reset();
                        swal("{{ trans('reference.update_password_success') }}", "{{ trans('reference.password_updated') }}", "success");
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        /* When click New expertise button */
        $('#new-expertise').click(function() {
            $('#btn-save').val("create-expertise");
            $('#expertise').trigger("reset");
            $('#expertiseCrudModal').html("{{ trans('reference.add_expertise') }}");
            $('#crud-modal').modal('show');
        });

        /* Edit expertise */
        $('body').on('click', '#edit-expertise', function() {
            var expert_id = $(this).data('id');
            $.get('experts/' + expert_id + '/edit', function(data) {
                $('#expertiseCrudModal').html("{{ trans('reference.edit_expertise') }}");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#exp_id').val(data.id);
                $('#expert_name').val(data.expert_name);
            });
        });

        /* Delete expertise */
        $('body').on('click', '#delete-expertise', function() {
            var expert_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "{{ trans('reference.confirm_delete') }}",
                text: "{{ trans('reference.irreversible_action') }}",
                type: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("{{ trans('reference.delete_success') }}", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        $.ajax({
                            type: "DELETE",
                            url: "experts/" + expert_id,
                            data: {
                                "id": expert_id,
                                "_token": token,
                            },
                            success: function() {
                                $("#expert_id_" + expert_id).remove();
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("{{ trans('reference.error_deleting') }}", "{{ trans('reference.try_again') }}", "error");
                            }
                        });
                    });
                }
            });
        });
    });
</script>

<script>
    error = false;

    function validate() {
        if (document.expForm.expert_name.value != '')
            document.expForm.btnsave.disabled = false;
        else
            document.expForm.btnsave.disabled = true;
    }
</script>
@endsection