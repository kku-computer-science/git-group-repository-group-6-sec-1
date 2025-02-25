@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('funds.fund_title'))

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('funds.fund_title') }}</h4>
            <p class="card-description">{{ __('funds.edit_description') }}</p>

            @php
                $locale = app()->getLocale();
            @endphp

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.fund_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_name ?? '-' }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.fund_year') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_year ?? '-' }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.fund_details') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_details ?? '-' }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.fund_type') }}</b></p>
                <p class="card-text col-sm-9">
                    {{ __('funds.fund_types.' . ($fund->fund_type ?? ''), [], $locale) }}
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.fund_level') }}</b></p>
                <p class="card-text col-sm-9">
                    {{ __('funds.fund_levels.' . ($fund->fund_level ?? 'empty'), [], $locale) }}
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.support_resource') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($fund->support_resource && array_key_exists($fund->support_resource, __('funds.support_resources')))
                        {{ __('funds.support_resources.' . $fund->support_resource) }}
                    @else
                        {{ $fund->support_resource ?? '-' }}
                    @endif
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.label.added_by') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($fund->user)
                        @if(app()->getLocale() == 'th')
                            {{ $fund->user->fname_th ?? '-' }} {{ $fund->user->lname_th ?? '-' }}
                        @else
                            {{ $fund->user->fname_en ?? '-' }} {{ $fund->user->lname_en ?? '-' }}
                        @endif
                    @else
                        -
                    @endif
                </p>
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('funds.index') }}"> {{ __('funds.back_button') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
