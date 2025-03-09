@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('research_groups.title'))

@section('content')
<div class="container">
    <div class="card col-md-10" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('research_groups.title') }}</h4>
            <p class="card-description">{{ __('research_groups.card_description') }}</p>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_name_th') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_th }}</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_name_en') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_desc_th') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_th }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_desc_en') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_desc_zh') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_zh }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_detail_th') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_detail_th }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_detail_en') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_detail_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_detail_zh') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_detail_zh }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_image') }}</b></p>
                <div class="col-sm-9">
                    @if($researchGroup->group_image)
                        <img src="{{ asset('storage/' . $researchGroup->group_image) }}" alt="{{ $researchGroup->group_name_th }}" style="max-width:300px;">
                    @else
                        <p>{{ __('research_groups.no_image') }}</p>
                    @endif
                </div>
            </div>
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ __('research_groups.label.group_head') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($researchGroup->user as $user)
                        @if($user->pivot->role == 1)
                            {{ app()->getLocale() == 'th' ? $user->position_th.' '.$user->fname_th.' '.$user->lname_th : $user->position_en.' '.$user->fname_en.' '.$user->lname_en }}
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3">
                    <b>{{ __('research_groups.label.group_member') }} ({{ __('research_groups.label.project_member_within') }})</b>
                </p>
                <p class="card-text col-sm-9">
                    @foreach($researchGroup->user as $user)
                        @if($user->pivot->role == 2)
                            {{ app()->getLocale() == 'th' ? $user->position_th.' '.$user->fname_th.' '.$user->lname_th : $user->position_en.' '.$user->fname_en.' '.$user->lname_en }}
                            @if(!$loop->last),@endif
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3">
                    <b>{{ __('research_groups.label.group_member') }} ({{ __('research_groups.label.project_member_outside') }})</b>
                </p>
                <p class="card-text col-sm-9">
                    @if($researchGroup->outsider)
                        @foreach($researchGroup->outsider as $outsider)
                            {{ app()->getLocale() == 'th' ? $outsider->fname_th.' '.$outsider->lname_th : $outsider->fname_en.' '.$outsider->lname_en }}
                            @if(!$loop->last),@endif
                        @endforeach
                    @else
                        {{ __('research_groups.no_member_outside') }}
                    @endif
                </p>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('researchGroups.index') }}">{{ __('research_groups.back_button') }}</a>
        </div>
    </div>
</div>
@stop
