@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>กลุ่มวิจัย</h2>
    <button class="btn btn-primary mb-3">+ ADD</button>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>Group name (ไทย)</th>
                    <th>Group name (อังกฤษ)</th>
                    <th>ชื่อการวิจัย (Research name)</th>
                    <th>จำนวนกลุ่มวิจัย</th>
                    <th>Form Link</th>
                    <th>Register</th>
                </tr>
            </thead>
            <tbody>
                @foreach($researchGroups as $group)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $group->name_th }}</td>
                    <td>{{ $group->name_en }}</td>
                    <td>{{ $group->research_name }}</td>
                    <td>{{ $group->group_count }}</td>
                    <td><a href="{{ $group->form_link }}" class="btn btn-link">Form</a></td>
                    <td><button class="btn btn-success">Register</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


