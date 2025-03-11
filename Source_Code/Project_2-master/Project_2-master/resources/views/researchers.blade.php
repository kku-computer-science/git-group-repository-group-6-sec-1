@php
    use App\Models\Program;
@endphp
@extends('layouts.layout')
@section('content')
<div class="container card-2">
    <p class="title">{{ __('researchers.title') }}</p> 
    @foreach($request as $res)
    <span>
        <ion-icon name="caret-forward-outline" size="small"></ion-icon>
        {{ trans('researchers.' . Program::getProgramCode($res->program_name_en)) }}
    </span>

    <div class="d-flex">
        <div class="ml-auto">
            <form class="row row-cols-lg-auto g-3" method="GET" action="{{ route('searchresearchers',['id'=>$res->id])}}">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="textsearch" placeholder="{{ __('datatables.search_interests') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary">{{ __('datatables.search') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-0">
        @foreach($users as $r)
        <a href=" {{ route('detail',Crypt::encrypt($r->id))}}">
            <div class="card mb-3">
                <div class="row g-0">
                    <!-- Image Section -->
                    <div class="col-sm-4">
                        <div class="card-image-container">
                            <img class="card-image" src="{{ $r->picture }}" alt="">
                        </div>
                    </div>

                    <!-- Text Section -->
                    <div class="col-sm-8 overflow-hidden" style="text-overflow: clip; @if(app()->getLocale() == 'en') max-height: 220px; @else max-height: 210px;@endif">
                        <div class="card-body">
                            @if(app()->getLocale() == 'en')
                                @if($r->doctoral_degree == 'Ph.D.')
                                    <h5 class="card-title">
                                        {{ $r->fname_en }} {{ $r->lname_en }}, {{ $r->doctoral_degree }}
                                    </h5>
                                @else
                                    <h5 class="card-title">
                                        {{ $r->fname_en }} {{ $r->lname_en }}
                                    </h5>
                                @endif
                                <h5 class="card-title-2">{{ $r->academic_ranks_en }}</h5>
                             @elseif(app()->getLocale() == 'th')
                                <h5 class="card-title">
                                    {{ $r->position_th }} {{ $r->fname_th }} {{ $r->lname_th }}
                                </h5>
                                <h5 class="card-title-2">{{ $r->academic_ranks_th }}</h5>
                            @elseif(app()->getLocale() == 'zh')
                                <h5 class="card-title">
                                    博士{{ __('academic_ranks.' . $r->academic_ranks_en) }} {{ $r->fname_en }} {{ $r->lname_en }}
                                </h5>
                                <h5 class="card-title-2">{{ __('academic_ranks.' . $r->academic_ranks_en) }}</h5>
                            @endif

                            <p class="card-text-1">{{ trans('message.expertise') }}</p>
                            <div class="card-expertise">
                            @foreach($r->expertise->sortBy('expert_name')->take(3) as $exper)
                                <p class="card-text">
                                    @if(app()->getLocale() == 'en')
                                        {{$exper->expert_name}}
                                    @elseif(app()->getLocale() == 'th')
                                        {{$exper->expert_name_th}}
                                    @elseif(app()->getLocale() == 'zh')
                                        {{$exper->expert_name_zh}}
                                    @endif
                                </p>
                            @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<style>
    .card-image-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-top: 150%; /* Aspect ratio 2:3 (2 width, 3 height) */
        overflow: hidden;
    }

    .card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the image covers the container without distortion */
    }

    .col-sm-4 {
        width: 30%; /* Set image container to 30% of the card */
        padding-right: 10px; /* Optional, to create space between image and text */
    }

    .col-sm-8 {
        width: 70%; /* Set text container to 70% of card */
    }
</style>
@endforeach
@stop