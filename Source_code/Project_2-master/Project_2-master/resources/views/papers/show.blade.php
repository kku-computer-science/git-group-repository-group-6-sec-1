@extends('dashboards.users.layouts.user-dash-layout')

<<<<<<< HEAD
=======
@section('title', __('published_research.title'))

>>>>>>> origin/Prommin_1406
@section('content')
<div class="container">
    <div class="card" style="padding: 16px;">
        <div class="card-body">
<<<<<<< HEAD
            <h4 class="card-title">รายละเอียดงานวารสาร</h4>
            <p class="card-description">ข้อมูลรายละเอียดวารสาร
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>ชื่อเรื่อง</b></p>
=======
            <h4 class="card-title">{{ __('published_research.title') }}</h4>
            <p class="card-description">{{ __('published_research.card_description') }}</p>
            
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_name') }}</b></p>
>>>>>>> origin/Prommin_1406
                <p class="card-text col-sm-9">{{ $paper->paper_name }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Abstract</b></p>
                <p class="card-text col-sm-9">{{ $paper->abstract }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Keyword</b></p>
<<<<<<< HEAD
                <p class="card-text col-sm-9">
                    {{ $paper->keyword }}
                </p>


                <!-- <p class="card-text col-sm-9">{{ $paper->keyword }}</p> -->
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ประเภทวารสาร</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_type }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ประเภทเอกสาร</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_subtype }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Publication</b></p>
                <p class="card-text col-sm-9">{{ $paper->publication }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ผู้เขียน</b></p>
                <p class="card-text col-sm-9">

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 1)
                    <b>First Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 1)
                    <b>First Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 2)
                    <b>Co Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 2)
                    <b>Co Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 3)
                    <b>Corresponding Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 3)
                    <b>Corresponding Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach
                    



                </p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ชื่องานวารสาร (sourcetitle)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_sourcetitle }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ปีที่ตีพิมพ์</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_yearpub }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>เล่มที่ (volume)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_volume }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ฉบับที่ (ISSUE)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_issue}}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>เลขหน้า</b></p>
=======
                <p class="card-text col-sm-9">{{ $paper->keyword }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_type') }}</b></p>
                <p class="card-text col-sm-9">{{ __('published_research.paper_types.' . $paper->paper_type) }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('published_research.paper_subtype') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_subtype }}</p>
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
>>>>>>> origin/Prommin_1406
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
<<<<<<< HEAD

            <a class="btn btn-primary mt-5" href="{{ route('papers.index') }}"> Back</a>
        </div>
    </div>

</div>
@endsection
=======
            <a class="btn btn-primary mt-5" href="{{ route('papers.index') }}">{{ __('published_research.back_button') }}</a>
        </div>
    </div>
</div>
@endsection
>>>>>>> origin/Prommin_1406
