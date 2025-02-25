@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

@section('content')
<!-- [Your existing CSS and initial JS remain unchanged] -->

<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success', __('users.success_message')) }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('users.title') }}</h4>
            <a class="btn btn-primary btn-icon-text btn-sm" href="{{ route('users.create') }}">
                <i class="ti-plus btn-icon-prepend icon-sm"></i>{{ __('users.new_user') }}
            </a>
            <a class="btn btn-primary btn-icon-text btn-sm" href="{{ route('importfiles') }}">
                <i class="ti-download btn-icon-prepend icon-sm"></i>{{ __('users.import_new_user') }}
            </a>

            <div class="table-responsive">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('users.table.id') }}</th>
                            <th>{{ __('users.table.name') }}</th>
                            <th>{{ __('users.table.department') }}</th>
                            <th>{{ __('users.table.email') }}</th>
                            <th>{{ __('users.table.roles') }}</th>
                            <th width="280px">{{ __('users.table.action') }}</th>
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
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('users.actions.view') }}" href="{{ route('users.show', $user->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </li>
                                    @can('user-edit')
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('users.actions.edit') }}" href="{{ route('users.edit', $user->id) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('user-delete')
                                    @csrf
                                    @method('DELETE')
                                    <li class="list-inline-item">
                                        <button id="deleted" class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('users.actions.delete') }}">
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
            </div>
        </div>
    </div>
</div>

<!-- [Your existing JS scripts remain unchanged] -->
@endsection