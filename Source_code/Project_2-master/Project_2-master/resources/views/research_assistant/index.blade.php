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
            <a class="btn btn-primary btn-sm mb-3" href="{{ route('researchAssistant.create') }}">
                <i class="mdi mdi-plus"></i> ADD
            </a>

            <table id="example1" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th style="width: 250px;">Group name (ไทย)</th>
                        <th style="width: 250px;">Group name (อังกฤษ)</th>
                        <th style="width: 300px;">ชื่องานวิจัย (Research name)</th>
                        <th style="width: 120px;">จำนวนผู้ช่วยวิจัย</th>
                        <th style="width: 180px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($researchAssistants as $index => $assistant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-wrap group-name">{{ $assistant->group_name_th }}</td>
                        <td class="text-wrap group-name">{{ $assistant->group_name_en }}</td>
                        <td class="text-wrap research-title">
                            {{ $assistant->researchProject->project_name ?? 'N/A' }}
                        </td>
                        <td>{{ $assistant->member_count }}</td>
                        <td>
                            <a href="{{ route('researchAssistant.edit', $assistant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('researchAssistant.destroy', $assistant->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<style>
    /* ป้องกันข้อความยาวดัน UI ออก */
    .group-name, .research-title {
        word-break: break-word;
        white-space: normal;
        max-width: 250px;
    }

    /* ให้ตาราง responsive */
    .table-responsive {
        overflow-x: auto;
    }

    th, td {
        word-wrap: break-word;
        white-space: normal;
    }
</style>

@endsection
