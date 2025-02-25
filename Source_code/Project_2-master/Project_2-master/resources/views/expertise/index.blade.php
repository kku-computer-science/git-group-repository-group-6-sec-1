@extends('dashboards.users.layouts.user-dash-layout')

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __('users.expertise_data_updated_successfully') }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title" style="text-align: center;">{{ __('experts.title') }}</h4>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('experts.id') }}</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>{{ __('experts.teacher_name') }}</th>
                        @endif
                        <th>{{ __('experts.name') }}</th>
                        <th>{{ __('experts.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($experts as $i => $expert)
                    <tr id="expert_id_{{ $expert->id }}">
                        <td>{{ $i+1 }}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td>{{ $expert->user->fname_en }} {{ $expert->user->lname_en }}</td>
                        @endif
                        <td>{{ $expert->expert_name }}</td>
                        <td>
                            <form action="{{ route('experts.destroy', $expert->id) }}" method="POST">
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-success btn-sm" id="edit-expertise" type="button" data-toggle="modal" data-id="{{ $expert->id }}" data-placement="top" title="{{ __('experts.edit') }}" href="javascript:void(0)">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </li>
                                @csrf
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <li class="list-inline-item">
                                    <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-id="{{ $expert->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('experts.delete') }}">
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

<!-- Add and Edit expertise modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="expertiseCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="expForm" action="{{ route('experts.store') }}" method="POST">
                    <input type="hidden" name="exp_id" id="exp_id">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('experts.name') }}:</strong>
                                <input type="text" name="expert_name" id="expert_name" class="form-control" placeholder="{{ __('experts.placeholder_name') }}" onchange="validate()">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ __('experts.submit') }}</button>
                            <a href="{{ route('experts.index') }}" class="btn btn-danger">{{ __('experts.cancel') }}</a>
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
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js" defer></script>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* When click New expertise button */
        $('#new-expertise').click(function() {
            $('#btn-save').val("create-expertise");
            $('#expertise').trigger("reset");
            $('#expertiseCrudModal').html("{{ __('experts.add') }}"); // ใช้การแปลภาษา
            $('#crud-modal').modal('show');
        });

        /* Edit expertise */
        $('body').on('click', '#edit-expertise', function() {
            var expert_id = $(this).data('id');
            $.get('experts/' + expert_id + '/edit', function(data) {
                $('#expertiseCrudModal').html("{{ __('experts.edit') }}"); // ใช้การแปลภาษา
                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#exp_id').val(data.id);
                $('#expert_name').val(data.expert_name);
            })
        });

        /* Delete expertise */
        $('body').on('click', '#delete-expertise', function(e) {
            var expert_id = $(this).data("id");
            
            var token = $("meta[name='csrf-token']").attr("content");
            e.preventDefault();
            swal({
                title: "{{ __('experts.confirm_title') }}", // แปลข้อความ "Are you sure?"
                text: "{{ __('experts.confirm_text') }}", // แปลข้อความ "You will not be able to recover this imaginary file!"
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('experts.delete_success') }}", { // แปลข้อความ "Delete Successfully"
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
                            success: function(data) {
                                $('#msg').html('{{ __('experts.delete_msg') }}'); // แปลข้อความ "program entry deleted successfully"
                                $("#expert_id_" + expert_id).remove();
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

<!-- เพิ่มสคริปต์ใหม่สำหรับ .show_confirm (ตามที่ระบุ) -->
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