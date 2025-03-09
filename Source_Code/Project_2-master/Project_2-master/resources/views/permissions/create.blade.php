@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ __('permissions.error_title') }}</strong> {{ __('permissions.error_message') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('permissions.create_permission') }}
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}">{{ __('permissions.permissions_list') }}</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'permissions.store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        <strong>{{ __('permissions.name') }}:</strong>
                        {!! Form::text('name', null, ['placeholder' => __('permissions.placeholder_name'), 'class' => 'form-control']) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('permissions.submit') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
