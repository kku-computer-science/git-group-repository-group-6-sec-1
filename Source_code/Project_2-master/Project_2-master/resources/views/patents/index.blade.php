@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
@section('title', __('patents.title'))

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('patents.title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('patents.create') }}">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('patents.add_button') }}
            </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('patents.no') }}</th>
                        <th>{{ __('patents.name') }}</th>
                        <th>{{ __('patents.type') }}</th>
                        <th>{{ __('patents.registration_date') }}</th>
                        <th>{{ __('patents.ref_number') }}</th>
                        <th>{{ __('patents.creator') }}</th>
                        <th width="280px">{{ __('patents.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patents as $i => $paper)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($paper->ac_name,50) }}</td>
                            <td>{{ __('patents.ac_type.' . ($paper->ac_type ?? '')) }}</td>
                            <td>{{ $paper->ac_year }}</td>
                            <td>{{ Str::limit($paper->ac_refnumber,50) }}</td>
                            <td>
                                @foreach($paper->user as $a)
                                    @if(app()->getLocale() == 'th')
                                        {{ $a->fname_th }} {{ $a->lname_th }}
                                    @else
                                        {{ $a->fname_en }} {{ $a->lname_en }}
                                    @endif
                                    @if(!$loop->last),@endif
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('patents.destroy', $paper->id) }}" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('patents.view') }}" href="{{ route('patents.show', $paper->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </li>
                                    @if(Auth::user()->can('update', $paper))
                                        <li class="list-inline-item">
                                            <a class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('patents.edit') }}" href="{{ route('patents.edit', $paper->id) }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(Auth::user()->can('delete', $paper))
                                        @csrf
                                        @method('DELETE')
                                        <li class="list-inline-item">
                                            <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('patents.delete') }}">
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
                title: `{{ __('patents.confirm_title') }}`,
                text: "{{ __('patents.confirm_text') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('patents.delete_success') }}", {
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
