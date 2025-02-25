@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __('users.user_updated_successfully') }}</p>
    </div>
    @endif
        <div class="card" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('roles.title') }}</h4>
                @can('role-create')
                <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('roles.create') }}">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>{{ __('roles.add') }}
                </a>
                @endcan

                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('roles.name') }}</th>
                            <th width="280px">{{ __('roles.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $key => $role)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <form action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('roles.view') }}" href="{{ route('roles.show',$role->id) }}"><i class="mdi mdi-eye"></i></a>
                                    @can('role-edit')
                                    <a class="btn btn-outline-success btn-sm " type="button" data-toggle="tooltip" data-placement="top" title="{{ __('roles.edit') }}" href="{{ route('roles.edit',$role->id) }}"><i class="mdi mdi-pencil"></i></a>
                                    @endcan

                                    @can('role-delete')
                                    @csrf
                                    @method('DELETE')

                                    <li class="list-inline-item">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" title="{{ __('roles.delete') }}"><i class="mdi mdi-delete"></i></button>
                                    </li>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->render() }}
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
