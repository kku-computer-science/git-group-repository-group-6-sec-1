@extends('dashboards.users.layouts.user-dash-layout')

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">

@section('content')
<div class="container">
    @if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ __(Session::get('success')) }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title" style="text-align: center;">{{ __('experts.title') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('experts.create') }}"><i class="mdi mdi-plus btn-icon-prepend"></i>{{ __('published_research.add_button') }}</a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('experts.id') }}</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>{{ __('experts.teacher_name') }}</th>
                        @endif
                        <th>{{ __('experts.name') }}</th>
                        <th>{{ __('experts.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($experts as $i => $expert)
                <tr id="expertise_id_{{ $expert->id }}">
                    <td>{{ $i+1 }}</td>
                    @if(Auth::user()->hasRole('admin'))
                    <td>
                        @if(app()->getLocale() == 'th')
                            {{ Str::limit($expert->user->fname_th . ' ' . $expert->user->lname_th, 20) }}
                        @elseif(app()->getLocale() == 'en')
                            {{ Str::limit($expert->user->fname_en . ' ' . $expert->user->lname_en, 20) }}
                        @elseif(app()->getLocale() == 'zh')
                            {{ Str::limit($expert->user->fname_en . ' ' . $expert->user->lname_en, 20) }}
                        @endif
                    </td>
                    @endif
                    <td>
                        @if(app()->getLocale() == 'th')
                            {{ $expert->expert_name_th ?? $expert->expert_name }}
                        @elseif(app()->getLocale() == 'zh')
                            {{ $expert->expert_name_zh ?? $expert->expert_name }}
                        @else
                            {{ $expert->expert_name }}
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('experts.destroy', $expert->id) }}" method="POST" class="delete-form">
                            <li class="list-inline-item">
                                <a class="btn btn-outline-success btn-sm edit-expertise" type="button" data-toggle="modal" data-id="{{ $expert->id }}" data-placement="top" title="{{ __('experts.edit') }}" href="javascript:void(0)"><i class="mdi mdi-pencil"></i></a>
                            </li>
                            @csrf
                            @method('DELETE')
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <li class="list-inline-item">
                                <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-id="{{ $expert->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('experts.delete') }}"><i class="mdi mdi-delete"></i></button>
                            </li>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="expertiseCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="expForm" action="" method="POST" id="expertForm">
                    <input type="hidden" name="exp_id" id="exp_id">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('experts.name') }}:</strong>
                                <input type="text" name="expert_name" id="expert_name" class="form-control" placeholder="{{ __('experts.placeholder_name_en') }}">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('experts.name_th') }}:</strong>
                                <input type="text" name="expert_name_th" id="expert_name_th" class="form-control" placeholder="{{ __('experts.placeholder_name_th') }}">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('experts.name_zh') }}:</strong>
                                <input type="text" name="expert_name_zh" id="expert_name_zh" class="form-control" placeholder="{{ __('experts.placeholder_name_zh') }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ __('experts.submit') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" data-bs-dismiss="modal">{{ __('experts.cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js" defer></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            order: [[0, 'asc']],
            rowGroup: {
                dataSrc: 1
            },
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.edit-expertise', function() {
            var expertise_id = $(this).data('id');
            $.get('{{ route("experts.index") }}/' + expertise_id + '/edit', function(data) {
                $('#expertiseCrudModal').html("{{ __('experts.edit') }}");
                $('#crud-modal').modal('show');
                $('#exp_id').val(data.id);
                $('#expertForm').attr('action', "{{ route('experts.update', '') }}/" + data.id);
                $('#expert_name').val(data.expert_name);
                $('#expert_name_th').val(data.expert_name_th);
                $('#expert_name_zh').val(data.expert_name_zh);
                validateForm();
            });
        });

        $('body').on('input', '#expert_name, #expert_name_th, #expert_name_zh', function() {
            validateForm();
        });

        function validateForm() {
            var nameFilled = $('#expert_name').val().trim() !== '';
            $('#btn-save').prop('disabled', !nameFilled);
        }

        // Updated to use event delegation for delete confirmation
        $(document).on('click', '.show_confirm', function(event) {
            event.preventDefault();
            var form = $(this).closest('.delete-form');

            swal({
                title: "{{ __('confirm.delete_title') }}",
                text: "{{ __('confirm.delete_text') }}",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "{{ __('confirm.cancel') }}",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true
                    },
                    confirm: {
                        text: "{{ __('confirm.ok') }}",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    });
</script>

@stop