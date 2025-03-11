@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
<style>
    .table-responsive {
        overflow-x: auto;
        min-height: 0.01%;
    }
    .table {
        width: 100% !important;
        min-width: 1000px; /* ปรับ min-width ใหม่ให้เหมาะสมกับขนาดที่ลดลง */
    }
    th:nth-child(2), td:nth-child(2) { /* คอลัมน์ Name (คอลัมน์ที่ 2) */
        max-width: 200px !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    th:nth-child(7), td:nth-child(7) { /* คอลัมน์ Action (คอลัมน์ที่ 7) */
        max-width: 100px !important;
        white-space: nowrap;
        overflow: hidden;
    }
    th:nth-child(1), td:nth-child(1) { /* คอลัมน์ No */
        max-width: 50px !important;
    }
    th:nth-child(3), td:nth-child(3) { /* คอลัมน์ Type */
        max-width: 80px !important;
    }
    th:nth-child(4), td:nth-child(4) { /* คอลัมน์ Registration Date */
        max-width: 100px !important;
    }
    th:nth-child(5), td:nth-child(5) { /* คอลัมน์ Registration Number */
        max-width: 120px !important;
    }
    th:nth-child(6), td:nth-child(6) { /* คอลัมน์ Creator */
        max-width: 150px !important;
    }
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .list-inline-item .btn-sm {
        padding: 0.1rem 0.2rem;
        font-size: 0.7rem;
    }
</style>
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
            <div class="table-responsive">
                <table id="example1" class="table table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('patents.no') }}</th>
                            <th>{{ __('patents.name') }}</th>
                            <th>{{ __('patents.type') }}</th>
                            <th>{{ __('patents.registration_date') }}</th>
                            <th>{{ __('patents.ref_number') }}</th>
                            <th>{{ __('patents.creator') }}</th>
                            <th>{{ __('patents.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patents as $i => $paper)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ Str::limit($paper->ac_name, 30) }}</td>
                                <td>{{ Str::limit(__('patents.ac_type.' . ($paper->ac_type ?? '')), 10) }}</td>
                                <td>{{ Str::limit($paper->ac_year, 10) }}</td>
                                <td>{{ Str::limit($paper->ac_refnumber, 20) }}</td>
                                <td>
                                    @foreach($paper->user as $a)
                                        @if(app()->getLocale() == 'th')
                                            {{ Str::limit($a->fname_th . ' ' . $a->lname_th, 15) }}
                                        @else
                                            {{ Str::limit($a->fname_en . ' ' . $a->lname_en, 15) }}
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
            </div>
            <br>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" defer></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        Swal.fire({
            title: `{{ __('patents.confirm_title') }}`,
            text: "{{ __('patents.confirm_text') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "{{ __('patents.confirm_yes') }}",
            cancelButtonText: "{{ __('patents.confirm_no') }}"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "{{ __('patents.delete_success') }}",
                    icon: "success",
                    timer: 1500
                }).then(function() {
                    location.reload();
                    form.submit();
                });
            }
        });
    });
</script>
@stop