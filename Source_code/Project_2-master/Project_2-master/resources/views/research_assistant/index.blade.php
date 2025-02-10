@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <h1>Research Assistant</h1>
    <button class="btn btn-primary mb-3">+ ADD</button>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Group name</th>
                    <th>Head</th>
                    <th>Member</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($assistants) && count($assistants) > 0)
                    @foreach($assistants as $assistant)
                    <tr>
                        <td>{{ $assistant['id'] }}</td>
                        <td>{{ $assistant['group_name'] }}</td>
                        <td>{{ $assistant['head'] }}</td>
                        <td>{{ $assistant['member'] }}</td>
                        <td>
                            <button class="btn btn-outline-primary">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
