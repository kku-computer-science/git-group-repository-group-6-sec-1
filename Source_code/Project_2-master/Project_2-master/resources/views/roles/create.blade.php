@extends('dashboards.users.layouts.user-dash-layout')
@section('content')

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ __('roles.error_title') }}</strong> {{ __('roles.error_message') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('roles.create_role') }}
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">{{ __('roles.roles_list') }}</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="form-group">
                        <strong>{{ __('roles.name') }}:</strong>
                        {!! Form::text('name', null, array('placeholder' => __('roles.placeholder_name'),'class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <strong>{{ __('roles.permission') }}:</strong>
                        <br/>
                        @foreach($permission as $value)
                    <label>
                        {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                        {{ __('roles.permissions.'.$value->name, [], app()->getLocale()) ?? $value->name }}
                    </label>
                    <br/>
                    @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('roles.submit') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



@endsection
