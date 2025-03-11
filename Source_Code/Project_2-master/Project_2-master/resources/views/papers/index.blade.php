@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('title','Dashboard')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('Published_research.title') }}</h4>
            @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('admin'))
                <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('papers.create') }}">
                    <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('Published_research.add_button') }}
                </a>
            @endif
            @if(Auth::user()->hasRole('teacher'))
                <a class="btn btn-primary btn-icon-text btn-sm mb-3" href="{{ route('callscopus', Crypt::encrypt(Auth::user()->id)) }}">
                    <i class="mdi mdi-refresh btn-icon-prepend icon-sm"></i> Call Paper
                </a>
            @endif

            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Published_research.no') }}</th>
                        <th>{{ __('Published_research.paper_name') }}</th>
                        <th>{{ __('Published_research.paper_type') }}</th>
                        <th>{{ __('Published_research.paper_yearpub') }}</th>
                        <th width="280px">{{ __('Published_research.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($papers->sortByDesc('paper_yearpub') as $i => $paper)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($paper->paper_name, 50) }}</td>
                            <td>{{ Str::limit(__('Published_research.paper_types.' . $paper->paper_type), 50) }}</td>
                            <td>{{ $paper->paper_yearpub }}</td>
                            <td>
                                <form action="{{ route('papers.destroy', $paper->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <!-- View Button -->
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View" href="{{ route('papers.show', $paper->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </li>

                                    <!-- Edit Button (Only for admin and owner) -->
                                    @if(Auth::user()->can('update', $paper) || Auth::user()->hasRole('admin'))
                                        <li class="list-inline-item">
                                            <a class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ route('papers.edit', Crypt::encrypt($paper->id)) }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Delete Button (Only for admin and owner) -->
                                    @if(Auth::user()->can('delete', $paper) || Auth::user()->hasRole('admin'))
                                        <li class="list-inline-item">
                                            <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </li>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
        </div>
    </div>
</div>

<!-- DataTable Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>

<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
            language: {
                lengthMenu: "@lang('datatables.lengthMenu')",
                search: "@lang('datatables.search')",
                info: "@lang('datatables.info')",
                infoEmpty: "@lang('datatables.infoEmpty')",
                zeroRecords: "@lang('datatables.zeroRecords')",
                paginate: {
                    first: "@lang('datatables.first')",
                    last: "@lang('datatables.last')",
                    next: "@lang('datatables.next')",
                    previous: "@lang('datatables.previous')"
                }
            }
        });
    });
</script>

<!-- Delete Confirmation -->
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
    event.preventDefault();

    var form = $(this).closest("form");
    var url = form.attr('action');

    swal({
        title: "Are you sure?",
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: 'DELETE',
                url: url,
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        swal("Deleted Successfully!", {
                            icon: "success",
                        }).then(() => {
                            window.location.href = "{{ route('papers.index') }}"; // กลับไปที่หน้า index
                        });
                    } else {
                        swal("Error!", response.error, "error");
                    }
                },
                error: function(response) {
                    swal("Error!", "Delete failed. Please try again.", "error");
                }
            });
        }
    });
});

</script>

@stop
