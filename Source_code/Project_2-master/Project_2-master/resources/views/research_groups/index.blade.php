@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<<<<<<< HEAD
@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">กลุ่มวิจัย</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('researchGroups.create') }}"><i
                    class="mdi mdi-plus btn-icon-prepend"></i> ADD</a>
            <!-- <div class="table-responsive"> -->
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
                    
                    <tbody>
                        @foreach ($researchGroups as $i=>$researchGroup)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ Str::limit($researchGroup->group_name_th,50) }}</td>
                            <td>
                                @foreach($researchGroup->user as $user)
                                @if ( $user->pivot->role == 1)

                                {{ $user->fname_th}}

                                @endif

                                @endforeach
                            </td>
                            <td>
                                @foreach($researchGroup->user as $user)
                                @if ( $user->pivot->role == 2)
                                {{ $user->fname_th}}
                                @if (!$loop->last),@endif
                                @endif

                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('researchGroups.destroy',$researchGroup->id) }}" method="POST">

                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip"
                                        data-placement="top" title="view"
                                        href="{{ route('researchGroups.show',$researchGroup->id) }}"><i
                                            class="mdi mdi-eye"></i></a>

                                    @if(Auth::user()->can('update',$researchGroup))
                                    <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip"
                                        data-placement="top" title="Edit"
                                        href="{{ route('researchGroups.edit',$researchGroup->id) }}"><i
                                            class="mdi mdi-pencil"></i></a>
                                    @endif

                                    @if(Auth::user()->can('delete',$researchGroup))
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip"
                                        data-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
=======
@section('title', __('research_groups.title'))

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('research_groups.title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('researchGroups.create') }}">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('research_groups.add_button') }}
            </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('research_groups.no') }}</th>
                        <th>{{ __('research_groups.group_name') }}</th>
                        <th>{{ __('research_groups.head') }}</th>
                        <th>{{ __('research_groups.member') }}</th>
                        <th width="280px">{{ __('research_groups.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($researchGroups as $i => $researchGroup)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($researchGroup->group_name_th, 50) }}</td>
                            <td>
                                @foreach ($researchGroup->user as $user)
                                    @if ($user->pivot->role == 1)
                                        {{ app()->getLocale() == 'th' ? $user->fname_th : $user->fname_en }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($researchGroup->user as $user)
                                    @if ($user->pivot->role == 2)
                                        {{ app()->getLocale() == 'th' ? $user->fname_th : $user->fname_en }}
                                        @if (!$loop->last),@endif
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('researchGroups.destroy', $researchGroup->id) }}" method="POST">
                                    <a class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('research_groups.view') }}"
                                        href="{{ route('researchGroups.show', $researchGroup->id) }}">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @if (Auth::user()->can('update', $researchGroup))
                                        <a class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('research_groups.edit') }}"
                                            href="{{ route('researchGroups.edit', $researchGroup->id) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    @endif
                                    @if (Auth::user()->can('delete', $researchGroup))
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('research_groups.delete') }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
>>>>>>> origin/Prommin_1406
                                    @endif
                                </form>
                            </td>
                        </tr>
<<<<<<< HEAD
                        @endforeach
                    </tbody>
                    
                </table>
            <!-- </div> -->
        </div>
    </div>
    

</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
<script src = "https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer ></script>
<script src = "https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer ></script>
=======
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
>>>>>>> origin/Prommin_1406
<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
<<<<<<< HEAD
=======
            language: {
                search: "{{ __('research_groups.search') }}"
            }
>>>>>>> origin/Prommin_1406
        });
    });
</script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
<<<<<<< HEAD
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure?`,
                text: "If you delete this, it will be gone forever.",
=======
        event.preventDefault();
        swal({
                title: `{{ __('research_groups.confirm_title') }}`,
                text: "{{ __('research_groups.confirm_text') }}",
>>>>>>> origin/Prommin_1406
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
<<<<<<< HEAD
                    swal("Delete Successfully", {
=======
                    swal("{{ __('research_groups.delete_success') }}", {
>>>>>>> origin/Prommin_1406
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>
<<<<<<< HEAD
@stop
=======
@stop
>>>>>>> origin/Prommin_1406
