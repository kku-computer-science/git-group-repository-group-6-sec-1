@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('books.detail_title'))

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('books.detail_title') }}</h4>
            <p class="card-description">{{ __('books.card_description') }}</p>
            
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.book_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.year') }}</b></p>
                <p class="card-text col-sm-9">
                    @if(app()->getLocale()=='th')
                        {{ date('Y', strtotime($paper->ac_year)) + 543 }}
                    @else
                        {{ date('Y', strtotime($paper->ac_year)) }}
                    @endif
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.publication') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_sourcetitle }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.page') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_page }}</p>
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}">{{ __('books.back_button') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
