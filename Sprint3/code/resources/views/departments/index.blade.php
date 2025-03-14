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
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('departments.name') }}</th>
                            <th width="280px">{{ __('departments.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>
                                @if (App::getLocale() == 'th')
                                    {{ $department->department_name_th }}
                                @elseif (App::getLocale() == 'en')
                                    {{ $department->department_name_en }}
                                @elseif (App::getLocale() == 'zh')
                                    {{ $department->department_name_zh }}
                                @else
                                    {{ $department->department_name_en }} {{-- ค่าเริ่มต้นเป็นภาษาอังกฤษ --}}
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('departments.destroy',$department->id) }}" method="POST">
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('departments.view') }}" href="{{ route('departments.show',$department->id) }}">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @can('departments-edit')
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('departments.edit') }}" href="{{ route('departments.edit',$department->id) }}">
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
