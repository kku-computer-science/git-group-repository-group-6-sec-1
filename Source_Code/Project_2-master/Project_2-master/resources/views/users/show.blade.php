@extends('dashboards.users.layouts.user-dash-layout')
@section('content')

<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div>
    @endif
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card" style="padding: 16px;">

            <div class="card-body">
                <h4 class="card-title">{{ __('users.user_info') }}</h4>
                <p class="card-description">{{ __('users.user_details') }}</p>
                
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.name_th') }}</b></h6>
                    <h6 class="col-md-9">{{$user->title_name_th}} {{ $user->fname_th }} {{ $user->lname_th }}</h6>
                </div>

                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.name_en') }}</b></h6>
                    <h6 class="col-md-9">{{$user->title_name_en}} {{ $user->fname_en }} {{ $user->lname_en }}</h6>
                </div>

                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('profile.email') }}</b></h6>
                    <h6 class="col-md-9">{{ $user->email }}</h6>
                </div>

                @foreach($user->getRoleNames() as $val)
                <div class="row mt-2">
                    <h6 class="col-md-3"><b>{{ __('users.role') }}</b></h6>
                    @foreach($user->getRoleNames() as $val)
                    <h6 class="col-md-9"><label class="badge badge-dark">{{ __("roles.$val")  }}</label></h6>
                    @endforeach
                </div>
                @endforeach

                @if($val == "teacher")
                    <div class="row mt-2">
                        <h6 class="col-md-3"><b>{{ __('users.academic_ranks') }}</b></h6>
                        <h6 class="col-md-9">
                            @if(App::getLocale() == 'th')
                                {{ $user->academic_ranks_th }} <!-- Thai translation -->
                            @elseif(App::getLocale() == 'zh')
                                {{ $user->academic_ranks_zh }} <!-- Chinese translation -->
                            @else
                                {{ $user->academic_ranks_en }} <!-- English translation -->
                            @endif
                        </h6>
                    </div>

                    <div class="row mt-2">
                        <h6 class="col-md-3"><b>{{ __('users.department') }}</b></h6>
                        <h6 class="col-md-9">
                            @if(App::getLocale() == 'th')
                                {{ $user->program->department->department_name_th }} <!-- Thai department name -->
                            @elseif(App::getLocale() == 'zh')
                                {{ $user->program->department->department_name_zh }} <!-- Chinese department name -->
                            @else
                                {{ $user->program->department->department_name_en }} <!-- English department name -->
                            @endif
                        </h6>
                    </div>

                    <div class="row mt-2">
                        <h6 class="col-md-3"><b>{{ __('users.program') }}</b></h6>
                        <h6 class="col-md-9">
                            @if(App::getLocale() == 'th')
                                {{ $user->program->program_name_th }} <!-- Thai program name -->
                            @elseif(App::getLocale() == 'zh')
                                {{ $user->program->program_name_zh }} <!-- Chinese program name -->
                            @else
                                {{ $user->program->program_name_en }} <!-- English program name -->
                            @endif
                        </h6>
                    </div>

                    <div class="row mt-2">
                        <h6 class="col-md-3"><b>{{ __('users.education_history') }}</b></h6>
                        <h6 class="col-md-4" style="line-height:1.4;">
                            @foreach($user->education as $edu)
                                @if(App::getLocale() == 'th')
                                    {{ $edu->qua_name }} <br> <!-- Thai qualification name -->
                                @elseif(App::getLocale() == 'zh')
                                    {{ $edu->qua_name_zh }} <br> <!-- Chinese qualification name -->
                                @else
                                    {{ $edu->qua_name_en }} <br> <!-- English qualification name -->
                                @endif
                            @endforeach
                        </h6>
                        <h6 class="col-md-5" style="line-height:1.4;">
                            @foreach($user->education as $edu)
                                @if(App::getLocale() == 'th')
                                    {{ $edu->uname }} <br> <!-- Thai university name -->
                                @elseif(App::getLocale() == 'zh')
                                    {{ $edu->university_zh }} <br> <!-- Chinese university name -->
                                @else
                                    {{ $edu->univerty_en }} <br> <!-- English university name -->
                                @endif
                            @endforeach
                        </h6>
                    </div>
                @endif


                @can('role-create')
                <a class="btn btn-primary btn-sm mt-5" href="{{ route('users.index') }}">{{ __('users.back') }}</a>
                @endcan
            </div>
        </div>
    </div>
</div>

@endsection