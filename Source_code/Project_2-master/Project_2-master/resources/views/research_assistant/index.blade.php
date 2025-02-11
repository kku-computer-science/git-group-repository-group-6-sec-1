@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">ผู้ช่วยวิจัย</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('researchAssistant.create') }}"><i
                    class="mdi mdi-plus btn-icon-prepend"></i> ADD</a>
                    <table id ="example1" class="table table-striped">
                    <thead>
                        <tr>    
                            <th>No.</th>
                            <th>Group name (ไทย)</th>
                            <th>Head</th>
                            <th>Member</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
    </div>

@endsection