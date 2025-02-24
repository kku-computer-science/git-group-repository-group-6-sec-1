@extends('dashboards.users.layouts.user-dash-layout')
@section('title', __('funds.title'))

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('funds.fund_title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('funds.create') }}">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('funds.add_button') }}
            </a>
            <div class="table-responsive">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('funds.no') }}</th>
                            <th>{{ __('funds.fund_name') }}</th>
                            <th>{{ __('funds.fund_type') }}</th>
                            <th>{{ __('funds.fund_level') }}</th>
                            <th>{{ __('funds.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funds as $i => $fund)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($fund->fund_name,80) }}</td>
                            <td>{{ __('funds.fund_types.' . $fund->fund_type) }}</td>
                            <td>
                                @if($fund->fund_level)
                                    @php $locale = app()->getLocale(); @endphp
                                    @if($locale == 'th')
                                        {{-- เมื่อเป็นภาษาไทย ใช้ไฟล์แปลภาษาไทย --}}
                                        {{ __('funds.fund_levels.' . $fund->fund_level) }}
                                    @elseif($locale == 'en')
                                        {{-- เมื่อเป็นภาษาอังกฤษ ใช้ไฟล์แปลภาษาอังกฤษ --}}
                                        {{ __('funds.fund_levels.' . $fund->fund_level) }}
                                    @elseif($locale == 'zh')
                                        {{-- เมื่อเป็นภาษาจีน ใช้ไฟล์แปลภาษาจีน --}}
                                        {{ __('funds.fund_levels.' . $fund->fund_level) }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @csrf
                                <form action="{{ route('funds.destroy', $fund->id) }}" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('funds.view') }}" href="{{ route('funds.show', $fund->id) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </li>
                                    @if(Auth::user()->can('update', $fund))
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('funds.edit') }}" href="{{ route('funds.edit', Crypt::encrypt($fund->id)) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </li>
                                    @endif

                                    @if(Auth::user()->can('delete', $fund))
                                    @csrf
                                    @method('DELETE')
                                    <li class="list-inline-item">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" title="{{ __('funds.delete') }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </li>
                                    @endcan
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

<!-- Scripts for Datatables and Confirm Dialog -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
$(document).ready(function() {
    var table = $('#example1').DataTable({
        fixedHeader: true,
        language: {
            search: "{{ __('datatables.search') }}"
        }
    });
});

</script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
                title: `{{ __('funds.confirm_title') }}`,
                text: "{{ __('funds.confirm_text') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("{{ __('funds.delete_success') }}", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>
@endsection
