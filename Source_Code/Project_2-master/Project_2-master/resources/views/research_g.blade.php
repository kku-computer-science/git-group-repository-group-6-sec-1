@extends('layouts.layout')
@section('content')
<div class="container card-3 ">
    <p>{{ trans('reference.research_group') }}</p>
    @foreach ($resg as $rg)
    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="card-body">
                    <img src="{{ asset('img/'.$rg->group_image) }}" alt="...">
                    <h2 class="card-text-1">{{ trans('reference.lab_supervisor') }}</h2>
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
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ app()->getLocale() == 'th' ? $rg->group_name_th : (app()->getLocale() == 'en' ? $rg->group_name_en : ($rg->group_name_zh ?? '-')) }}
                    </h5>
                    <h3 class="card-text">{{ Str::limit($rg->{'group_desc_'.app()->getLocale()}, 350) }}</h3>
                </div>
                <div>
                    <a href="{{ route('researchgroupdetail', ['id' => $rg->id]) }}"
                        class="btn btn-outline-info">{{ trans('reference.details') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop