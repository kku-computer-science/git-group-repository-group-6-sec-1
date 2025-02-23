@extends('dashboards.users.layouts.user-dash-layout')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@section('title', __('published_research.title'))
@section('content')
<style type="text/css">
    .dropdown-toggle .filter-option {
        height: 40px;
        width: 400px !important;
        color: #212529;
        background-color: #fff;
        border-width: 0.2;
        border-style: solid;
        border-color: -internal-light-dark(rgb(118, 118, 118), rgb(133, 133, 133));
        border-radius: 5px;
        padding: 4px 10px;
    }
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 5px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('published_research.confirm_title') }}</strong> {{ __('published_research.confirm_text') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('published_research.add_button') }} {{ __('published_research.title') }}</h4>
            <p class="card-description">{{ __('published_research.card_description') }}</p>
            <form action="{{ route('papers.store') }}" method="POST">
                @csrf
                <!-- Publication Source -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.publication') }}</b></label>
                    <div class="col-sm-9">
                        <select class="selectpicker" multiple data-live-search="true" name="cat[]">
                            @foreach($source as $s)
                            <option value="{{ $s->id }}">{{ $s->source_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Paper Name -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_name') }}</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="paper_name" class="form-control" placeholder="{{ __('published_research.paper_name') }}">
                    </div>
                </div>
                <!-- Abstract -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>Abstract</b></label>
                    <div class="col-sm-9">
                        <textarea name="abstract" class="form-control form-control-lg" style="height:150px" placeholder="Abstract"></textarea>
                    </div>
                </div>
                <!-- Keyword -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>Keyword</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="keyword" class="form-control" placeholder="Keyword">
                        <p class="text-danger">{{ __('published_research.keyword_instruction') }}</p>
                    </div>
                </div>
                <!-- Paper Type -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_type') }}</b></label>
                    <div class="col-sm-9">
                        <select id="paper_type" class="custom-select my-select" style="width: 200px;" name="paper_type">
                            <option value="" disabled selected>{{ __('published_research.select_type_default') }}</option>
                            @foreach(__('published_research.paper_types') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Paper Subtype -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_subtype') }}</b></label>
                    <div class="col-sm-9">
                        <select id="paper_subtype" class="custom-select my-select" style="width: 200px;" name="paper_subtype">
                            <option value="" disabled selected>{{ __('published_research.select_subtype_default') }}</option>
                            <option value="Article">Article</option>
                            <option value="Conference Paper">Conference Paper</option>
                            <option value="Editorial">Editorial</option>
                            <option value="Book Chapter">Book Chapter</option>
                            <option value="Erratum">Erratum</option>
                            <option value="Review">Review</option>
                        </select>
                    </div>
                </div>
                <!-- Source Title (Publication) -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.publication') }}</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="paper_sourcetitle" class="form-control" placeholder="{{ __('published_research.publication') }}">
                    </div>
                </div>
                <!-- Year Published -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_yearpub') }}</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="paper_yearpub" class="form-control" placeholder="{{ __('published_research.paper_yearpub') }}">
                    </div>
                </div>
                <!-- Volume -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_volume') }}</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="paper_volume" class="form-control" placeholder="{{ __('published_research.paper_volume') }}">
                    </div>
                </div>
                <!-- Issue -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_issue') }}</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="paper_issue" class="form-control" placeholder="{{ __('published_research.paper_issue') }}">
                    </div>
                </div>
                <!-- Page -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.paper_page') }}</b></label>
                    <div class="col-sm-4">
                        <input type="text" name="paper_page" class="form-control" placeholder="{{ __('published_research.paper_page') }}">
                    </div>
                </div>
                <!-- DOI -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>DOI</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="paper_doi" class="form-control" placeholder="DOI">
                    </div>
                </div>
                <!-- Funder -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.funder') }}</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="paper_funder" class="form-control" placeholder="Funder">
                    </div>
                </div>
                <!-- URL -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>URL</b></label>
                    <div class="col-sm-9">
                        <input type="text" name="paper_url" class="form-control" placeholder="URL">
                    </div>
                </div>
                <!-- Author Name (Internal) -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.author_internal') }}</b></label>
                    <div class="col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamicAddRemoveAuthors">
                                <tr>
                                    <td>
                                        <select id="selUser0" style="width: 200px;" name="moreFields[0][userid]">
                                            <option value="">{{ __('published_research.select_member') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ app()->getLocale() == 'th' ? $user->fname_th . ' ' . $user->lname_th : $user->fname_en . ' ' . $user->lname_en }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </td>
                                    <td>
                                        <select id="pos" class="custom-select my-select" style="width: 200px;" name="pos[]">
                                        <option value="1">{{ __('published_research.pos.first_author') }}</option>
                                            <option value="2">{{ __('published_research.pos.co_author') }}</option>
                                            <option value="3">{{ __('published_research.pos.corresponding_author') }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Author Name (External) -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><b>{{ __('published_research.author_external') }}</b></label>
                    <div class="col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td>
                                        <input type="text" name="fname[]" placeholder="{{ __('published_research.placeholder.author_fname') }}" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <input type="text" name="lname[]" placeholder="{{ __('published_research.placeholder.author_lname') }}" class="form-control name_list" />
                                    </td>
                                    <td>
                                        <select id="pos" class="custom-select my-select" style="width: 200px;" name="pos[]">
                                            <option value="1">{{ __('published_research.pos.first_author') }}</option>
                                            <option value="2">{{ __('published_research.pos.co_author') }}</option>
                                            <option value="3">{{ __('published_research.pos.corresponding_author') }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary me-2">{{ __('published_research.submit_button') }}</button>
                <a class="btn btn-light" href="{{ route('papers.index') }}">{{ __('published_research.back_button') }}</a>
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script>
$(document).ready(function() {
    $("#selUser0").select2();
    $("#head0").select2();
    var i = 0;
    var selectOptions = `
        @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ app()->getLocale() == 'th' ? $user->fname_th.' '.$user->lname_th : $user->fname_en.' '.$user->lname_en }}
            </option>
        @endforeach
    `;
    $("#add-btn2").click(function() {
        ++i;
        var newRow = `
            <tr>
                <td>
                    <select id="selUser${i}" name="moreFields[${i}][userid]" style="width: 200px;">
                        <option value="">{{ __('published_research.select_member') }}</option>
                        ${selectOptions}
                    </select>
                </td>
                <td>
                    <select id="pos" class="custom-select my-select" style="width: 200px;" name="pos[]">
                        <option value="1">First Author</option>
                        <option value="2">Co-Author</option>
                        <option value="3">Corresponding Author</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-tr"><i class="fas fa-minus"></i></button>
                </td>
            </tr>
        `;
        $("#dynamicAddRemoveAuthors").append(newRow);
        $("#selUser" + i).select2();
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).closest('tr').remove();
    });
});
</script>
<script>
$(document).ready(function() {
    var j = 0;
    $('#addMore2').click(function() {
        j++;
        $('#dynamic_field').append(`
            <tr id="row${j}" class="dynamic-added">
                <td><input type="text" name="fname[]" placeholder="{{ __('published_research.placeholder.author_fname') }}" style="width: 300px;" class="form-control" /></td>
                <td><input type="text" name="lname[]" placeholder="{{ __('published_research.placeholder.author_lname') }}" style="width: 300px;" class="form-control" /></td>
                <td>
                    <select id="pos2" class="custom-select my-select" style="width: 200px;" name="pos2[]">
                        <option value="1">First Author</option>
                        <option value="2">Co-Author</option>
                        <option value="3">Corresponding Author</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm btn_remove"><i class="fas fa-minus"></i></button></td>
            </tr>
        `);
    });
    $(document).on('click', '.btn_remove', function() {
        $(this).closest('tr').remove();
    });
});
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@stop
