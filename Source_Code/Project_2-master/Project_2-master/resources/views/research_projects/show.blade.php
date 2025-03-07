@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('research_projects.detail_title'))

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('research_projects.title') }}</h4>
            <p class="card-description">{{ __('research_projects.card_description') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_start') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_start }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_end') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_end }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.fund_source') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->fund->fund_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.budget') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->budget }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_note') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->note }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_status') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($researchProject->status == 1)
                        {{ __('research_projects.status.submitted') }}
                    @elseif($researchProject->status == 2)
                        {{ __('research_projects.status.in_progress') }}
                    @else
                        {{ __('research_projects.status.closed') }}
                    @endif
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_head') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($researchProject->user as $user)
                        @if($user->pivot->role == 1)
                            {{ app()->getLocale() == 'th' ? $user->fname_th : $user->fname_en }}
                            {{ app()->getLocale() == 'th' ? $user->lname_th : $user->lname_en }}
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('research_projects.label.project_member') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($researchProject->user as $user)
                        @if($user->pivot->role == 2)
                            {{ app()->getLocale() == 'th' ? $user->fname_th : $user->fname_en }}
                            {{ app()->getLocale() == 'th' ? $user->lname_th : $user->lname_en }}
                            @if (!$loop->last),@endif
                        @endif
                    @endforeach

                    @if($researchProject->programs)
                        @foreach($researchProject->programs as $program)
                            @if($program->pivot->role == 2)
                                ,{{ app()->getLocale() == 'th' ? $program->program_name_th : $program->program_name_en }}
                                @if (!$loop->last),@endif
                            @endif
                        @endforeach
                    @else
                        <!-- <p>ไม่มีโปรแกรมที่เกี่ยวข้อง</p> -->
                    @endif
                </p>
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary" href="{{ route('researchProjects.index') }}">
                    {{ __('research_projects.back_button') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
