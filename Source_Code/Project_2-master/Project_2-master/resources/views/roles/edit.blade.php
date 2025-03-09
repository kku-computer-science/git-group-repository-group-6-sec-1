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
        <div class="card col-8" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('roles.edit_role') }}</h4>
                {!! Form::model($role, ['route' => ['roles.update', $role->id],'method' => 'PATCH']) !!}
                <div class="form-group row">
                    <p class="col-sm-3">{{ __('roles.name') }}:</p>
                    <div class="col-sm-8">
                        {!! Form::text('name', null, array('placeholder' => __('roles.placeholder_name'),'class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <p class="col-sm-3">{{ __('roles.permission') }}</p>
                    <div class="col-sm-9">
                    @foreach($permission as $value)
                    <label>
                        {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                        {{ __('roles.permissions.'.$value->name, [], app()->getLocale()) ?? $value->name }}
                    </label>
                    <br/>
                    @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">{{ __('roles.submit') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('roles.index') }}">{{ __('roles.back') }}</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
