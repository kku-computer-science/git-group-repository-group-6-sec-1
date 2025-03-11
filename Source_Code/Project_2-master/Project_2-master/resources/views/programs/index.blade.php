@extends('dashboards.users.layouts.user-dash-layout')

<!-- ลบ CSS ที่ซ้ำและจัดระเบียบ -->
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
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="javascript:void(0)" id="new-program" data-toggle="modal">
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
                        <td>{{ $program->program_name_th }}</td>
                        <td>{{ $program->degree->degree_name_en }}</td>
                        <td>
                            <form action="{{ route('programs.destroy', $program->id) }}" method="POST">
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-success btn-sm" id="edit-program" type="button" data-toggle="modal" data-id="{{ $program->id }}" data-placement="top" title="{{ __('programs.edit') }}" href="javascript:void(0)">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </li>
                                <!-- ย้าย CSRF Token ไปไว้ใน head ของเลย์เอาต์หลัก -->
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
                                <input type="text" name="program_name_th" id="program_name_th" class="form-control" placeholder="{{ __('programs.placeholder_name_th') }}" onkeyup="validate()">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('programs.name_en') }}:</strong>
                                <input type="text" name="program_name_en" id="program_name_en" class="form-control" placeholder="{{ __('programs.placeholder_name_en') }}" onkeyup="validate()">
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

<!-- DataTables Initialization -->
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

<!-- CRUD Operations -->
<script>
    $(document).ready(function() {
        // When click New program button
        $('#new-program').click(function() {
            $('#btn-save').val("create-program");
            $('form[name="proForm"]')[0].reset(); // รีเซ็ตฟอร์ม
            $('#programCrudModal').html("{{ __('programs.add') }}");
            $('#crud-modal').modal('show');
            validate(); // เรียกตรวจสอบทันทีเพื่อปิดปุ่มบันทึกถ้าฟอร์มว่าง
        });

        // Edit program
        $('body').on('click', '#edit-program', function() {
            var program_id = $(this).data('id');
            $.get('programs/' + program_id + '/edit', function(data) {
                $('#programCrudModal').html("{{ __('programs.edit') }}");
                $('#btn-save').val("update-program");
                $('#crud-modal').modal('show');
                $('#pro_id').val(data.id);
                $('#program_name_th').val(data.program_name_th);
                $('#program_name_en').val(data.program_name_en);
                $('#degree').val(data.degree_id);
                $('#department').val(data.department_id); // เพิ่มการตั้งค่า department
                validate(); // ตรวจสอบฟอร์มหลังโหลดข้อมูล
            }).fail(function() {
                swal("เกิดข้อผิดพลาด!", "ไม่สามารถดึงข้อมูลได้", "error");
            });
        });

        // Form submission with AJAX
        $('form[name="proForm"]').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $('#pro_id').val() ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(data) {
                    $('#crud-modal').modal('hide');
                    swal("สำเร็จ!", "บันทึกข้อมูลเรียบร้อยแล้ว", "success").then(function() {
                        location.reload(); // รีเฟรชหน้าเพื่ออัปเดตตาราง
                    });
                },
                error: function(xhr) {
                    swal("เกิดข้อผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้", "error");
                }
            });
        });
    });

    // Validate form
    function validate() {
        var programNameTh = $('#program_name_th').val();
        var programNameEn = $('#program_name_en').val();
        $('#btn-save').prop('disabled', (programNameTh === '' || programNameEn === ''));
    }

    // Delete program with confirmation
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var program_id = $(this).data("id");
        event.preventDefault();
        swal({
            title: "{{ __('confirm.delete_title') }}",
            text: "{{ __('confirm.delete_text') }}",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "{{ __('confirm.cancel') }}",
                    value: null,
                    visible: true,
                    className: "btn btn-secondary",
                    closeModal: true
                },
                confirm: {
                    text: "{{ __('confirm.ok') }}",
                    value: true,
                    visible: true,
                    className: "btn btn-primary",
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "DELETE",
                    url: "programs/" + program_id,
                    data: { "_token": $("meta[name='csrf-token']").attr("content") },
                    success: function(data) {
                        $("#program_id_" + program_id).remove(); // ลบแถวทันที
                        swal("{{ __('confirm.delete_success') }}", { icon: "success" });
                    },
                    error: function(xhr) {
                        swal("เกิดข้อผิดพลาด!", "ไม่สามารถลบข้อมูลได้", "error");
                    }
                });
            }
        });
    });
</script>

@stop