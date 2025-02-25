@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
@section('content')
<div class="container">
    <div class="justify-content-center">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __('users.permission_updated_successfully') }}</p>
    </div>
    @endif
        <div class="card">
            <div class="card-header">{{ __('permissions.title') }}
                @can('permission-create')
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('permissions.create') }}">{{ __('permissions.new_permission') }}</a>
                </span>
                @endcan
            </div>
            <div class="card-body">
                <table id="example1" class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('permissions.name') }}</th>
                            <th width="280px">{{ __('permissions.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ __('permissions.'.$permission->name, [], app()->getLocale()) ?? $permission->name }}</td>
                            <td>
                                <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('permissions.view') }}" href="{{ route('permissions.show',$permission->id) }}"><i class="mdi mdi-eye"></i></a>
                                    </li>
                                    @can('permission-edit')
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('permissions.edit') }}" href="{{ route('permissions.edit',$permission->id) }}"><i class="mdi mdi-pencil"></i></a>
                                    </li>
                                    @endcan
                                    @can('permission-delete')
                                    @csrf
                                    @method('DELETE')
                                    <li class="list-inline-item">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('permissions.delete') }}"><i class="mdi mdi-delete"></i></button>
                                    </li>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
                title: `@lang('confirm.delete_title')`, 
                text: "@lang('confirm.delete_text')", 
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "@lang('confirm.cancel')",  // ใช้คำว่า "Cancel" ที่แปล
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "@lang('confirm.ok')",  // ใช้คำว่า "OK" ที่แปล
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
                    swal("@lang('confirm.delete_success')", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>
@endsection
