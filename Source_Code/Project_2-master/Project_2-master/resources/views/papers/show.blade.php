@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('published_research.title'))

@section('content')
<div class="container">
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('published_research.title') }}</h4>
            <p class="card-description">{{ __('published_research.card_description') }}</p>
            
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_name }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3">Abstract ({{ strtoupper(app()->getLocale()) }})</p>
                <p class="col-sm-9">{{ $translatedAbstract }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3">{{ __('paper_keyword.keyword') }}</p>
                <p class="card-text col-sm-9">{{ $translatedKeywords }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_type') }}</b></p>
                <p class="card-text col-sm-9">{{ __('published_research.paper_types.' . $paper->paper_type) }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('paper_keyword.paper_subtype') }}</b></p>
                <p class="card-text col-sm-9">{{ __('paper_keyword.subtypes.' . $paper->paper_subtype) }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.publication') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->publication }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_yearpub') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_yearpub }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_volume') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_volume }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_issue') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_issue }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_page') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_page }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>DOI</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_doi }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>URL</b></p>
                <a href="{{ $paper->paper_url }}" target="_blank" class="card-text col-sm-9">{{ $paper->paper_url }}</a>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('papers.index') }}">{{ __('published_research.back_button') }}</a>
        </div>
    </div>
</div>
@endsection