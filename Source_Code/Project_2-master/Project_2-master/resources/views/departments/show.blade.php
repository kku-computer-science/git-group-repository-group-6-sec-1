@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('departments.details') }}
                @can('role-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('departments.index') }}">{{ __('departments.back') }}</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>{{ __('departments.name_th') }}:</strong>
                    {{ $department->department_name_th }}
                </div>
                <div class="lead">
                    <strong>{{ __('departments.name_en') }}:</strong>
                    {{ $department->department_name_en }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
