@extends('layouts.layout')
<style>
    .name {
        font-size: 20px;
    }
</style>
@section('content')
<div class="container card-4 mt-5">
    <div class="card">
        <p>{{ trans('reference.research_group') }}</p>
        @foreach ($resgd as $rg)
        <div class="row g-0">
            <div class="col-md-4">
                <div class="card-body">
                    <img src="{{ asset('img/'.$rg->group_image) }}" alt="...">
                    <h1 class="card-text-1">{{ trans('reference.lab_supervisor') }}</h1>
                    <h2 class="card-text-2">
                        @foreach ($rg->user as $r)
                        @if($r->hasRole('teacher'))
                        @php
                            // กำหนด locale สำหรับชื่อและตำแหน่ง: ถ้าเป็น 'zh' ให้ใช้ 'en'
                            $nameLocale = (app()->getLocale() == 'zh') ? 'en' : app()->getLocale();
                        @endphp
                        @if(app()->getLocale() == 'en' and $r->academic_ranks_en == 'Lecturer' and $r->doctoral_degree == 'Ph.D.')
                            {{ $r->{'fname_'.$nameLocale} }} {{ $r->{'lname_'.$nameLocale} }}, Ph.D.
                            <br>
                        @elseif(app()->getLocale() == 'en' and $r->academic_ranks_en == 'Lecturer')
                            {{ $r->{'fname_'.$nameLocale} }} {{ $r->{'lname_'.$nameLocale} }}
                            <br>
                        @elseif(app()->getLocale() == 'en' and $r->doctoral_degree == 'Ph.D.')
                            {{ str_replace('Dr.', ' ', $r->{'position_'.$nameLocale}) }} {{ $r->{'fname_'.$nameLocale} }} {{ $r->{'lname_'.$nameLocale} }}, Ph.D.
                            <br>
                        @else                            
                            {{ $r->{'position_'.$nameLocale} }} {{ $r->{'fname_'.$nameLocale} }} {{ $r->{'lname_'.$nameLocale} }}
                            <br>
                        @endif
                        @endif
                        @endforeach
                    </h2>
                    <h1 class="card-text-1">{{ trans('reference.student') }}</h1>
                    <h2 class="card-text-2">
                        @foreach ($rg->user as $user)
                        @if($user->hasRole('student'))
                            {{ $user->{'position_'.$nameLocale} }} {{ $user->{'fname_'.$nameLocale} }} {{ $user->{'lname_'.$nameLocale} }}
                            <br>
                        @endif
                        @endforeach
                    </h2>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $rg->group_name_en }}</h5>
                    @php
                        // กำหนด locale สำหรับคำอธิบาย: ใช้ภาษาปัจจุบัน (ไม่เปลี่ยน 'en' เป็น 'zh')
                        $descLocale = app()->getLocale();
                    @endphp
                    <h3 class="card-text">{{ $rg->{'group_detail_'.$descLocale} ?? $rg->group_detail_en }}</h3>
                   
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        $(".moreBox").slice(0, 1).show();
        if ($(".blogBox:hidden").length != 0) {
            $("#loadMore").show();
        }
        $("#loadMore").on('click', function(e) {
            e.preventDefault();
            $(".moreBox:hidden").slice(0, 1).slideDown();
            if ($(".moreBox:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
            }
        });
    });
</script>

@stop