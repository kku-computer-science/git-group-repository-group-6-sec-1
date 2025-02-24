@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        <div class="card col-8" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('roles.title') }}</h4>
                <p class="card-description">{{ __('roles.description') }}</p>
                <div class="row">
                    <p class="card-text col-sm-3"><b>{{ __('roles.name') }}</b></p>
                    <p class="card-text col-sm-9">{{ $role->name }}</p>
                </div>
                <div class="row mt-3">
                    <p class="card-text col-sm-3"><b>{{ __('roles.role_permissions') }}</b></p>
                    @if(!empty($rolePermissions))
                    <p class="card-text col-sm-9" style="line-height: 1.85rem;">
                        @foreach($rolePermissions as $permission)
                        <label class="badge badge-success">{{ __('roles.permissions.'.$permission->name) }}</label>
                        @endforeach
                    </p>
                    @endif
                </div>
                @can('role-create')
                <a class="btn btn-primary mt-5" href="{{ route('roles.index') }}">{{ __('roles.back') }}</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
