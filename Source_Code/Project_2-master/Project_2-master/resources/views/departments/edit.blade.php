@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ __('departments.error_title') }}</strong> {{ __('departments.error_message') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('departments.edit') }}
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('departments.index') }}">{{ __('departments.list') }}</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($department, ['route' => ['departments.update', $department->id], 'method'=>'PATCH']) !!}
                    <div class="form-group">
                        <strong>{{ __('departments.name_th') }}:</strong>
                        {!! Form::text('department_name_th', null, ['placeholder' => __('departments.placeholder_name_th'), 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>{{ __('departments.name_en') }}:</strong>
                        {!! Form::text('department_name_en', null, ['placeholder' => __('departments.placeholder_name_en'), 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>{{ __('departments.name_zh') }}:</strong>
                        {!! Form::text('department_name_zh', null, ['placeholder' => __('departments.placeholder_name_zh'), 'class' => 'form-control']) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('departments.submit') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
