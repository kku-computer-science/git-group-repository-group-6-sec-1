@extends('dashboards.users.layouts.user-dash-layout')

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __($message) }}</p> <!-- แปลข้อความจาก Session -->
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
                    <td>
                        @if(app()->getLocale() == 'th')
                            {{ Str::limit($expert->user->fname_th . ' ' . $expert->user->lname_th, 20) }}
                        @elseif(app()->getLocale() == 'en')
                            {{ Str::limit($expert->user->fname_en . ' ' . $expert->user->lname_en, 20) }}
                        @elseif(app()->getLocale() == 'zh')
                            {{ Str::limit($expert->user->fname_en . ' ' . $expert->user->lname_en, 20) }} <!-- Fixed: Correct field for Chinese -->
                        @endif
                    </td>
                    @endif

                    <td>
                        @if(app()->getLocale() == 'th')
                            {{ $expert->expert_name_th }} <!-- Thai name -->
                        @elseif(app()->getLocale() == 'zh')
                            {{ $expert->expert_name_zh }} <!-- Chinese name -->
                        @else
                            {{ $expert->expert_name }} <!-- Default name (English or fallback) -->
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('experts.destroy', $expert->id) }}" method="POST">
                            <li class="list-inline-item">
                                <a class="btn btn-outline-success btn-sm" id="edit-expertise" type="button" data-toggle="modal" data-id="{{ $expert->id }}" data-placement="top" title="{{ __('experts.edit') }}" href="javascript:void(0)"><i class="mdi mdi-pencil"></i></a>
                            </li>
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <li class="list-inline-item">
                                <button class="btn btn-outline-danger btn-sm show_confirm" id="delete-expertise" type="submit" data-id="{{ $expert->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('experts.delete') }}"><i class="mdi mdi-delete"></i></button>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            order: [[0, 'asc']], // Order by the first column (which represents the ID)
            rowGroup: {
                dataSrc: 1
            },
            language: {
                lengthMenu: "{{ __('datatables.lengthMenu') }}",
                search: "{{ __('datatables.search') }}",
                info: "{{ __('datatables.info') }}",
                infoEmpty: "{{ __('datatables.infoEmpty') }}",
                zeroRecords: "{{ __('datatables.zeroRecords') }}",
                paginate: {
                    first: "{{ __('datatables.first') }}",
                    last: "{{ __('datatables.last') }}",
                    next: "{{ __('datatables.next') }}",
                    previous: "{{ __('datatables.previous') }}"
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
            $('#expertiseCrudModal').html("{{ __('experts.add') }}");
            $('#crud-modal').modal('show');
        });

        /* Edit expertise */
        $('body').on('click', '#edit-expertise', function() {
            var expert_id = $(this).data('id');
            $.get('experts/' + expert_id + '/edit', function(data) {
                $('#expertiseCrudModal').html("{{ __('experts.edit') }}");
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
                title: "{{ __('experts.confirm_title') }}",
                text: "{{ __('experts.confirm_text') }}",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "{{ __('experts.cancel') }}",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "{{ __('experts.ok') }}",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('experts.delete_success') }}", {
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
                                $('#msg').html('{{ __('experts.delete_msg') }}');
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