@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
@section('title', __('published_research.title'))

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('published_research.title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('papers.create') }}">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('published_research.add_button') }}
            </a>
            @if(Auth::user()->hasRole('teacher'))
                <a class="btn btn-primary btn-icon-text btn-sm mb-3" href="{{ route('callscopus', Crypt::encrypt(Auth::user()->id)) }}">
                    <i class="mdi mdi-refresh btn-icon-prepend icon-sm"></i> {{ __('published_research.call_paper') }}
                </a>
            @endif
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('published_research.no') }}</th>
                        <th>{{ __('published_research.paper_name') }}</th>
                        <th>{{ __('published_research.paper_type') }}</th>
                        <th>{{ __('published_research.paper_yearpub') }}</th>
                        <th width="280px">{{ __('published_research.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($papers->sortByDesc('paper_yearpub') as $i => $paper)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($paper->paper_name, 50) }}</td>
                            <td>{{ __('published_research.paper_types.' . $paper->paper_type) }}</td>
                            <td>{{ $paper->paper_yearpub }}</td>
                            <td>
                                <form action="{{ route('papers.destroy', $paper->id) }}" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('published_research.view') }}" href="{{ route('papers.show', $paper->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </li>
                                    @if(Auth::user()->can('update', $paper))
                                        <li class="list-inline-item">
                                            <a class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('published_research.edit') }}" href="{{ route('papers.edit', Crypt::encrypt($paper->id)) }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
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
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            language: {
                search: "{{ __('published_research.search') }}"
            }
        });
    });
</script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
            title: `{{ __('published_research.confirm_title') }}`,
            text: "{{ __('published_research.confirm_text') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal("{{ __('published_research.delete_success') }}", {
                    icon: "success",
                }).then(function() {
                    location.reload();
                    form.submit();
                });
            }
        });
    });
</script>
@stop
