@extends('dashboards.users.layouts.user-dash-layout')

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

<style type="text/css">
    .dropdown-toggle {
        height: 40px;
        width: 70px !important;
    }

    body label:not(.input-group-text) {
        margin-top: 10px;
    }

    body .my-select {
        background-color: #EFEFEF;
        color: #212529;
        border: 0 none;
        border-radius: 10px;
        padding: 6px 20px;
        width: 100%;
    }
</style>

@section('content')
<div class="container">
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __('users.program_data_updated_successfully') }}</p>
    </div>
@endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title" style="text-align: center;">{{ __('programs.title') }}</h4>
            <a class="btn btn-primary btn-icon-text btn-sm mb-3" href="javascript:void(0)" id="new-program" data-toggle="modal" style="padding: 6px 12px; min-width: 120px; text-align: center;">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('programs.add') }}
            </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('programs.id') }}</th>
                        <th>{{ __('programs.name_th') }}</th>
                        <th>{{ __('programs.degree') }}</th>
                        <th>{{ __('programs.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($programs as $i => $program)
                    <tr id="program_id_{{ $program->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>
                            @if (App::getLocale() == 'th')
                                {{ $program->program_name_th }}
                            @elseif (App::getLocale() == 'zh')
                                {{ $program->program_name_zh ?? $program->program_name_en }}
                            @else
                                {{ $program->program_name_en }}
                            @endif
                        </td>
                        <td>
                        @if (App::getLocale() == 'th')
                            {{ $program->degree->degree_name_th }}
                        @elseif (App::getLocale() == 'zh')
                            {{ $program->degree->degree_name_zh ?? $program->degree->degree_name_en }}
                        @else
                            {{ $program->degree->degree_name_en }}
                        @endif
                        </td>
                        <td>
                            <form action="{{ route('programs.destroy', $program->id) }}" method="POST">
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-success btn-sm" id="edit-program" type="button" data-toggle="modal" data-id="{{ $program->id }}" data-placement="top" title="{{ __('programs.edit') }}" href="javascript:void(0)">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </li>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <li class="list-inline-item">
                                    <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-id="{{ $program->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('programs.delete') }}">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </li>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add and Edit program modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="programCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="proForm" action="{{ route('programs.store') }}" method="POST">
                    <input type="hidden" name="pro_id" id="pro_id">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('programs.degree') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="degree" class="custom-select my-select" name="degree">
                                        @foreach($degree as $d)
                                        <option value="{{$d->id}}">{{$d->degree_name_th}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('programs.department') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="department" class="custom-select my-select" name="department">
                                        @foreach($department as $d)
                                        <option value="{{$d->id}}">{{$d->department_name_th}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('programs.name_th') }}:</strong>
                                <input type="text" name="program_name_th" id="program_name_th" class="form-control" placeholder="{{ __('programs.placeholder_name_th') }}" onchange="validate()">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('programs.name_en') }}:</strong>
                                <input type="text" name="program_name_en" id="program_name_en" class="form-control" placeholder="{{ __('programs.placeholder_name_en') }}" onchange="validate()">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ __('programs.submit') }}</button>
                            <a href="{{ route('programs.index') }}" class="btn btn-danger">{{ __('programs.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
            language: {
                lengthMenu: "@lang('datatables.lengthMenu')",
                search: "@lang('datatables.search')",
                info: "@lang('datatables.info')",
                infoEmpty: "@lang('datatables.infoEmpty')",
                zeroRecords: "@lang('datatables.zeroRecords')",
                paginate: {
                    first: "@lang('datatables.first')",
                    last: "@lang('datatables.last')",
                    next: "@lang('datatables.next')",
                    previous: "@lang('datatables.previous')"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        /* When click New program button */
        $('#new-program').click(function() {
            $('#btn-save').val("create-program");
            $('#program').trigger("reset");
            $('#programCrudModal').html("{{ __('programs.add') }}"); // ใช้การแปลภาษา
            $('#crud-modal').modal('show');
        });

        /* Edit program */
        $('body').on('click', '#edit-program', function() {
            var program_id = $(this).data('id');
            $.get('programs/' + program_id + '/edit', function(data) {
                $('#programCrudModal').html("{{ __('programs.edit') }}"); // ใช้การแปลภาษา
                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#pro_id').val(data.id);
                $('#program_name_th').val(data.program_name_th);
                $('#program_name_en').val(data.program_name_en);
                //$('#degree').val(data.program_name_en);
                $('#degree').val(data.degree_id);
            })
        });

        /* Delete program */
        $('body').on('click', '#delete-program', function(e) {
            var program_id = $(this).data("id");

            var token = $("meta[name='csrf-token']").attr("content");
            e.preventDefault();
            swal({
                title: "{{ __('programs.confirm_title') }}", // แปลข้อความ "Are you sure?"
                text: "{{ __('programs.confirm_text') }}", // แปลข้อความ "You will not be able to recover this imaginary file!"
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('programs.delete_success') }}", { // แปลข้อความ "Delete Successfully"
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        $.ajax({
                            type: "DELETE",
                            url: "programs/" + program_id,
                            data: {
                                "id": program_id,
                                "_token": token,
                            },
                            success: function(data) {
                                $('#msg').html('{{ __('programs.delete_msg') }}'); // แปลข้อความ "program entry deleted successfully"
                                $("#program_id_" + program_id).remove();
                            },
                            error: function(data) {
                                console.log('Error:', data);
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
        document.expForm.btnsave.disabled = false
    else
        document.expForm.btnsave.disabled = true
    }
</script>

<!-- เพิ่มสคริปต์สำหรับ .show_confirm -->
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
                title: "{{ __('confirm.delete_title') }}", 
                text: "{{ __('confirm.delete_text') }}", 
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "{{ __('confirm.cancel') }}",  // ใช้คำว่า "Cancel" ที่แปล
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "{{ __('confirm.ok') }}",  // ใช้คำว่า "OK" ที่แปล
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('confirm.delete_success') }}", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>

@stop