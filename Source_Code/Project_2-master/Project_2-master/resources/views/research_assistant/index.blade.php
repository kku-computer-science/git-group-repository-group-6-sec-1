@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: '{{ $message }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง'
        });
    </script>
    @endif

    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">ผู้ช่วยวิจัย</h4>
            <a class="btn btn-primary btn-sm mb-3" href="{{ route('researchAssistant.create') }}">
                <i class="mdi mdi-plus"></i> ADD
            </a>

            <div class="table-responsive">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th style="width: 250px;">Group name (ไทย)</th>
                            <th style="width: 250px;">Group name (อังกฤษ)</th>
                            <th style="width: 300px;">ชื่องานวิจัย (Research name)</th>
                            <th style="width: 120px;">จำนวนผู้ช่วยวิจัย</th>
                            <th style="width: 200px;">Form Link</th>
                            <th style="width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($researchAssistants as $index => $assistant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-wrap group-name">{{ $assistant->group_name_th }}</td>
                            <td class="text-wrap group-name">{{ $assistant->group_name_en }}</td>
                            <td class="text-wrap research-title">{{ $assistant->researchProject->project_name ?? 'N/A' }}</td>
                            <td>{{ $assistant->member_count }}</td>
                            <td>
                                @if($assistant->form_link)
                                    <a href="{{ $assistant->form_link }}" target="_blank" class="btn btn-sm btn-info">View Form</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('researchAssistant.edit', $assistant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                
                                <!-- ปุ่ม Delete ที่ใช้ SweetAlert2 -->
                                <button class="btn btn-sm btn-danger delete-button" data-id="{{ $assistant->id }}">
                                    Delete
                                </button>

                                <form id="delete-form-{{ $assistant->id }}" action="{{ route('researchAssistant.destroy', $assistant->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<style>
    
    .group-name, .research-title {
        word-break: break-word;
        white-space: normal;
        max-width: 250px;
    }

   
    .table-responsive {
        overflow-x: auto;
    }

    th, td {
        word-wrap: break-word;
        white-space: normal;
    }
</style>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ค้นหาปุ่ม delete ทั้งหมด
    let deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            let researchAssistantId = this.getAttribute('data-id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "If you delete this, it will be gone forever.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${researchAssistantId}`).submit();
                }
            });
        });
    });
});
</script>

@endsection
