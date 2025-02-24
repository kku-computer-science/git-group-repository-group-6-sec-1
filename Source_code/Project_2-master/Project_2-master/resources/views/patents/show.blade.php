@extends('dashboards.users.layouts.user-dash-layout')

<<<<<<< HEAD
=======
@section('title', __('patents.detail_title'))

>>>>>>> origin/Prommin_1406
@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
<<<<<<< HEAD
            <h4 class="card-title">รายละเอียดผลงานวิชาการอื่นๆ (สิทธิบัตร, อนุสิทธิบัตร,ลิขสิทธิ์)</h4>
            <p class="card-description">ข้อมูลรายละเอียดผลงานวิชาการอื่นๆ (สิทธิบัตร, อนุสิทธิบัตร,ลิขสิทธิ์)</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>ชื่อ</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>ประเภท</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_type }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>วันที่จดทะเบียน</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>เลขทะเบียน</b></p>
                <p class="card-text col-sm-9">เลขที่ : {{ $patent->ac_refnumber }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>ผู้จัดทำ</b></p>
                <p class="card-text col-sm-9">@foreach($patent->user as $a)
                    {{ $a->fname_th }} {{ $a->lname_th }}
                @if (!$loop->last),@endif
                @endforeach
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>ผู้จัดทำ (ร่วม)</b></p>
                <p class="card-text col-sm-9">
                @foreach($patent->author as $a)
                    {{ $a->author_fname }} {{ $a->author_lname }}
                @if (!$loop->last),@endif
                @endforeach</p>
            </div>
            
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('patents.index') }}"> Back</a>
=======
            <h4 class="card-title">{{ __('patents.detail_title') }}</h4>
            <p class="card-description">{{ __('patents.card_description') }}</p>
            
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.name') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.type') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_type }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.registration_date') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.ref_number') }}</b></p>
                <p class="card-text col-sm-9">{{ __('patents.ref_number_label') }} {{ $patent->ac_refnumber }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.creator') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($patent->user as $a)
                        {{ $a->fname_th }} {{ $a->lname_th }}@if(!$loop->last),@endif
                    @endforeach
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.co_creator') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($patent->author as $a)
                        {{ $a->author_fname }} {{ $a->author_lname }}@if(!$loop->last),@endif
                    @endforeach
                </p>
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('patents.index') }}">{{ __('patents.back_button') }}</a>
>>>>>>> origin/Prommin_1406
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> origin/Prommin_1406
