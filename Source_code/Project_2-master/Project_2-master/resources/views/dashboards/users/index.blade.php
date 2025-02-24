@extends('dashboards.users.layouts.user-dash-layout')
<<<<<<< HEAD
@section('title','Dashboard')

@section('content')

<h3 style="padding-top: 10px;">ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลวิจัยของสาขาวิชาวิทยาการคอมพิวเตอร์</h3>
<br>
<h4>สวัสดี {{Auth::user()->position_th}} {{Auth::user()->fname_th}} {{Auth::user()->lname_th}}</h2>
=======
@section('title', __('dashboard.title'))

@section('content')

<h3 style="padding-top: 10px;">{{ __('dashboard.welcome_message') }}</h3>
<br>
@php
    $locale = app()->getLocale();
@endphp

@if($locale == 'th')
    <h4>{{ __('dashboard.greeting') }} {{ Auth::user()->position_th }} {{ Auth::user()->fname_th }} {{ Auth::user()->lname_th }}</h4>
@elseif($locale == 'zh')
    <h4>{{ __('dashboard.greeting') }} {{ Auth::user()->position_en }} {{ Auth::user()->fname_en }} {{ Auth::user()->lname_en }}</h4>
@else
    <h4>{{ __('dashboard.greeting') }} {{ Auth::user()->position_en }} {{ Auth::user()->fname_en }} {{ Auth::user()->lname_en }}</h4>
@endif
>>>>>>> origin/Prommin_1406

@endsection
