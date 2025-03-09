@extends('dashboards.users.layouts.user-dash-layout')

<!-- ลิงก์ CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('title', __('books.title'))

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('books.title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('books.create') }}">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('books.add_button') }}
            </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('books.no') }}</th>
                        <th>{{ __('books.book_name') }}</th>
                        <th>{{ __('books.year') }}</th>
                        <th>{{ __('books.publication') }}</th>
                        <th>{{ __('books.page') }}</th>
                        <th width="280px">{{ __('books.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $i => $book)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($book->ac_name, 50) }}</td>
                            <td>{{ date('Y', strtotime($book->ac_year)) + 543 }}</td>
                            <td>{{ Str::limit($book->ac_sourcetitle, 50) }}</td>
                            <td>{{ $book->ac_page }}</td>
                            <td>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                    <ul class="list-inline">
                                        <!-- ปุ่ม View -->
                                        <li class="list-inline-item">
                                            <a class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('books.view') }}" href="{{ route('books.show', $book->id) }}">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </li>
                                        <!-- ปุ่ม Edit -->
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update', $book))
                                            <li class="list-inline-item">
                                                <a class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('books.edit') }}" href="{{ route('books.edit', $book->id) }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                            </li>
                                        @endif
                                        <!-- ปุ่ม Delete -->
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete', $book))
                                            @csrf
                                            @method('DELETE')
                                            <li class="list-inline-item">
                                                <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('books.delete') }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
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

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
            language: {
                lengthMenu: "{{ __('datatables.lengthMenu') }}",
                search: "{{ __('datatables.search') }}",
                info: "{{ __('datatables.info') }}",
                infoEmpty: "{{ __('datatables.infoEmpty') }}",
                zeroRecords: "{{ __('datatables.zeroRecords') }}",
                paginate: {
                    first: "{{ __('datatables.first') }}",
                    last: "{{ __('datatables.last') }}",
                    next: "{{ __('datatables.next') }}",
                    previous: "{{ __('datatables.previous') }}"
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
            title: "{{ __('books.confirm_title') }}",
            text: "{{ __('books.confirm_text') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // แก้ไขส่วนที่ซ้ำซ้อน แต่คงโครงสร้างเดิม
                swal("{{ __('books.delete_success') }}", {
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