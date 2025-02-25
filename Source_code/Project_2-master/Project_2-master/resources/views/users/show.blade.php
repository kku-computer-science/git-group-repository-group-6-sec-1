@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success', __('users.success_message')) }}</p>
    </div>
    @endif
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('users.title') }}</h4>
                <p class="card-description">{{ __('users.description') }}</p>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.name_th') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->title_name_th }} {{ $user->fname_th }} {{ $user->lname_th }}</h6>
                </div>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.name_en') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->title_name_en }} {{ $user->fname_en }} {{ $user->lname_en }}</h6>
                </div>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.email') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->email }}</h6>
                </div>
                @foreach($user->getRoleNames() as $val)
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.role') }}</b></h6>
                    <h6 class="col-md-9"><label class="badge badge-dark">{{ __("users.roles.{$val}") }}</label></h6>
                </div>
                @endforeach
                @if($val == "teacher")
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.academic_ranks') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->academic_ranks_en }}</h6>
                </div>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.department') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->program->department->department_name_en }}</h6>
                </div>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.program') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->program->program_name_en }}</h6>
                </div>
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.education_history') }}</b></h6>
                    <h6 class="col-md-4" style="line-height:1.4;">
                        @foreach($user->education as $edu)
                            {{ $edu->qua_name }} <br>
                        @endforeach
                    </h6>
                    <h6 class="col-md-5" style="line-height:1.4;">
                        @foreach($user->education as $edu)
                            {{ $edu->uname }} <br>
                        @endforeach
                    </h6>
                </div>
                @endif
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.fields.password') }}</b></h6>
                    <h6 class="col-md-9"></h6>
                </div>
                @can('role-create')
                <a class="btn btn-primary btn-sm mt-5" href="{{ route('users.index') }}">{{ __('users.back_button') }}</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection