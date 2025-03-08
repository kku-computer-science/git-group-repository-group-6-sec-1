@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

@section('content')
<!-- [Your existing CSS and initial JS remain unchanged] -->

<div class="container">
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __('users.user_updated_successfully') }}</p>
    </div>
@endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('users.title') }}</h4>
            <a class="btn btn-primary btn-icon-text btn-sm" href="{{ route('users.create')}}"><i class="ti-plus btn-icon-prepend icon-sm"></i> {{ __('users.new_user') }}</a>
            <a class="btn btn-primary btn-icon-text btn-sm" href="{{ route('importfiles')}}"><i class="ti-download btn-icon-prepend icon-sm"></i> {{ __('users.import_user') }}</a>

            <div class="table-responsive">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('users.name') }}</th>
                            <th>{{ __('users.department') }}</th>
                            <th>{{ __('users.email') }}</th>
                            <th>{{ __('users.roles') }}</th>
                            <th width="280px">{{ __('users.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->fname_en }} {{ $user->lname_en }}</td>
                            <td>{{ Str::limit(__("users.program_options.{$user->program->id}"), 20) }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $val)
                                <label class="badge badge-dark">{{ __("users.roles.{$val}") }}</label>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('users.view') }}" href="{{ route('users.show',$user->id) }}"><i class="mdi mdi-eye"></i></a>
                                </li>
                                
                                    @can('user-edit')
                                    <li class="list-inline-item">
                                    <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('users.edit') }}" href="{{ route('users.edit',$user->id) }}"><i class="mdi mdi-pencil"></i></a>
                                    </li>
                                    @endcan
                                    @can('user-delete')
                                    @csrf
                                    @method('DELETE')
                                    <li class="list-inline-item">
                                        <button id="deleted" class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('users.delete') }}"><i class="mdi mdi-delete"></i></button>
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
