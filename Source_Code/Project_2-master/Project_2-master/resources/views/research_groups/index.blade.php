@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
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
                                    @endif
                                </form>
                            </td>
                        </tr>
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
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
                title: `@lang('confirm.delete_title')`, 
                text: "@lang('confirm.delete_text')", 
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "@lang('confirm.cancel')",  // ใช้คำว่า "Cancel" ที่แปล
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "@lang('confirm.ok')",  // ใช้คำว่า "OK" ที่แปล
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("@lang('confirm.delete_success')", {
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
