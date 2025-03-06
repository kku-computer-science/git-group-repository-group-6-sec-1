@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ __('users.department_updated_successfully') }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('departments.title') }}
                @can('departments-create')
                <a class="btn btn-primary" href="{{ route('departments.create') }}">{{ __('departments.new_department') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-hover" id="departments-table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th> <!-- คอลัมน์ 1 -->
                        <th>{{ __('departments.name') }}</th> <!-- คอลัมน์ 2 -->
                        <th width="280px">{{ __('departments.action') }}</th> <!-- คอลัมน์ 3 -->
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($data as $key => $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>{{ $department->department_name_th }}</td>
                            <td>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('departments.view') }}" href="{{ route('departments.show', $department->id) }}">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @can('departments-edit')
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('departments.edit') }}" href="{{ route('departments.edit', $department->id) }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endcan

                                    @can('departments-delete')
                                    @csrf
                                    @method('DELETE')
                                    <li class="list-inline-item">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('departments.delete') }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </li>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>

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
                        text: "@lang('confirm.cancel')",  
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "@lang('confirm.ok')",  
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

    // เพิ่มการดีบักเพื่อตรวจสอบว่า DataTables โหลดเสร็จ
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded and parsed');
        if (typeof $('#departments-table').DataTable === 'function') {
            console.log('DataTable initialized for departments-table');
        } else {
            console.log('DataTable not initialized for departments-table');
        }
    });
</script>
@endsection