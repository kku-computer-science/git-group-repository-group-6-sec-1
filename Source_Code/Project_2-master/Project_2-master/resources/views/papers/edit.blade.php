@extends('dashboards.users.layouts.user-dash-layout')
@section('title', __('published_research.edit_title'))
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
    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('published_research.error_title') }}</strong> {{ __('published_research.error_text') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('published_research.edit_title') }}</h4>
                <p class="card-description">{{ __('published_research.edit_description') }}</p>
                <form class="forms-sample" action="{{ route('papers.update', $paper->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <p class="col-sm-3"><b>{{ __('published_research.publication_source') }}</b></p>
                        <div class="col-sm-8">
                            {!! Form::select('sources[]', $sources, $paperSource, ['class' => 'selectpicker', 'multiple', 'data-live-search' => 'true']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_name" class="col-sm-3 col-form-label">{{ __('published_research.paper_name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_name" value="{{ $paper->paper_name }}" class="form-control" placeholder="{{ __('published_research.placeholder.paper_name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputabstract" class="col-sm-3 col-form-label">{{ __('published_research.Abstract') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="abstract" placeholder="{{ __('published_research.placeholder.abstract') }}" class="form-control form-control-lg" style="height:150px">{{ $paper->abstract }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputkeyword" class="col-sm-3 col-form-label">{{ __('published_research.Keyword') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="keyword" value="{{ $paper->keyword }}" class="form-control" placeholder="{{ __('published_research.placeholder.keyword') }}">
                            <p class="text-danger">{{ __('published_research.keyword_instruction') }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_sourcetitle" class="col-sm-3 col-form-label">{{ __('published_research.publication') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_sourcetitle" value="{{ $paper->paper_sourcetitle }}" class="form-control" placeholder="{{ __('published_research.placeholder.publication') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_type" class="col-sm-3 col-form-label">{{ __('published_research.paper_type') }}</label>
                        <div class="col-sm-9">
                            <select id='paper_type' class="custom-select my-select" style='width: 200px;' name="paper_type">
                                <option value="Journal" {{ "Journal" == $paper->paper_type ? 'selected' : '' }}>{{ __('published_research.paper_types.Journal') }}</option>
                                <option value="Conference Proceeding" {{ "Conference Proceeding" == $paper->paper_type ? 'selected' : '' }}>{{ __('published_research.paper_types.Conference Proceeding') }}</option>
                                <option value="Book Series" {{ "Book Series" == $paper->paper_type ? 'selected' : '' }}>{{ __('published_research.paper_types.Book Series') }}</option>
                                <option value="Book" {{ "Book" == $paper->paper_type ? 'selected' : '' }}>{{ __('published_research.paper_types.Book') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_subtype" class="col-sm-3 col-form-label">{{ __('published_research.paper_subtype') }}</label>
                        <div class="col-sm-9">
                            <select id='paper_subtype' class="custom-select my-select" style='width: 200px;' name="paper_subtype">
                                <option value="Article" {{ "Article" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Article') }}</option>
                                <option value="Conference Paper" {{ "Conference Paper" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Conference Paper') }}</option>
                                <option value="Editorial" {{ "Editorial" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Editorial') }}</option>
                                <option value="Book Chapter" {{ "Book Chapter" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Book Chapter') }}</option>
                                <option value="Erratum" {{ "Erratum" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Erratum') }}</option>
                                <option value="Review" {{ "Review" == $paper->paper_subtype ? 'selected' : '' }}>{{ __('published_research.subtypes.Review') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpublication" class="col-sm-3 col-form-label">{{ __('published_research.publication') }}</label>
                        <div class="col-sm-9">
                            <select id='publication' class="custom-select my-select" style='width: 200px;' name="publication">
                                <option value="International Journal" {{ "International Journal" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.International Journal') }}</option>
                                <option value="International Book" {{ "International Book" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.International Book') }}</option>
                                <option value="International Conference" {{ "International Conference" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.International Conference') }}</option>
                                <option value="National Conference" {{ "National Conference" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.National Conference') }}</option>
                                <option value="National Journal" {{ "National Journal" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.National Journal') }}</option>
                                <option value="National Book" {{ "National Book" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.National Book') }}</option>
                                <option value="National Magazine" {{ "National Magazine" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.National Magazine') }}</option>
                                <option value="Book Chapter" {{ "Book Chapter" == $paper->publication ? 'selected' : '' }}>{{ __('published_research.publication_types.Book Chapter') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_yearpub" class="col-sm-3 col-form-label">{{ __('published_research.paper_yearpub') }}</label>
                        <div class="col-sm-9">
                            <input type="number" name="paper_yearpub" value="{{ $paper->paper_yearpub }}" class="form-control" placeholder="{{ __('published_research.placeholder.paper_yearpub') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_volume" class="col-sm-3 col-form-label">{{ __('published_research.paper_volume') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_volume" value="{{ $paper->paper_volume }}" class="form-control" placeholder="{{ __('published_research.placeholder.paper_volume') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_issue" class="col-sm-3 col-form-label">{{ __('published_research.paper_issue') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_issue" value="{{ $paper->paper_issue }}" class="form-control" placeholder="{{ __('published_research.placeholder.paper_issue') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_citation" class="col-sm-3 col-form-label">{{ __('published_research.citation') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_citation" value="{{ $paper->paper_citation }}" class="form-control" placeholder="{{ __('published_research.placeholder.citation') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_page" class="col-sm-3 col-form-label">{{ __('published_research.paper_page') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_page" value="{{ $paper->paper_page }}" class="form-control" placeholder="{{ __('published_research.placeholder.paper_page') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_doi" class="col-sm-3 col-form-label">{{ __('published_research.doi') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_doi" value="{{ $paper->paper_doi }}" class="form-control" placeholder="{{ __('published_research.placeholder.doi') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_funder" class="col-sm-3 col-form-label">{{ __('published_research.funder') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_funder" value="{{ $paper->paper_funder }}" class="form-control" placeholder="{{ __('published_research.placeholder.funder') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_url" class="col-sm-3 col-form-label">{{ __('published_research.url') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="paper_url" value="{{ $paper->paper_url }}" class="form-control" placeholder="{{ __('published_research.placeholder.url') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_doi" class="col-sm-3 ">{{ __('published_research.author_internal') }}</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table " id="dynamicAddRemove">
                                    <tr>
                                        <td><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputpaper_author" class="col-sm-3 col-form-label">{{ __('published_research.author_external') }}</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamic_field">
                                    <tr>
                                        <td><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{ __('published_research.submit_button') }}</button>
                    <a class="btn btn-light" href="{{ route('papers.index') }}">{{ __('published_research.cancel_button') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Internal Authors (teacher)
        var papers = <?php echo json_encode($paper->teacher ?? []); ?>;
        var i = 0;
        if (Array.isArray(papers)) {
            for (i = 0; i < papers.length; i++) {
                var obj = papers[i];
                $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                    '][userid]" style="width: 200px;">@foreach($users as $user)<option value="{{ $user->id }}">{{ app()->getLocale() == "th" ? $user->fname_th . " " . $user->lname_th : $user->fname_en . " " . $user->lname_en }}</option>@endforeach</select></td><td><select id="pos' + i + '" class="custom-select my-select" style="width: 200px;" name="pos[]"><option value="1">{{ __("published_research.pos.first_author") }}</option><option value="2">{{ __("published_research.pos.co_author") }}</option><option value="3">{{ __("published_research.pos.corresponding_author") }}</option></select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
                );
                document.getElementById("selUser" + i).value = obj.id || '';
                document.getElementById("pos" + i).value = obj.pivot?.author_type || obj.author_type || '';
                $("#selUser" + i).select2();
            }
        }

        $("#add-btn2").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                '][userid]" style="width: 200px;"><option value="">{{ __("published_research.select_member") }}</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ app()->getLocale() == "th" ? $user->fname_th . " " . $user->lname_th : $user->fname_en . " " . $user->lname_en }}</option>@endforeach</select></td><td><select id="pos' + i + '" class="custom-select my-select" style="width: 200px;" name="pos[]"><option value="1">{{ __("published_research.pos.first_author") }}</option><option value="2">{{ __("published_research.pos.co_author") }}</option><option value="3">{{ __("published_research.pos.corresponding_author") }}</option></select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
            );
            $("#selUser" + i).select2();
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        // External Authors (author)
        var patent = <?php echo json_encode($paper->author ?? []); ?>;
        var j = 0;
        if (Array.isArray(patent)) {
            for (j = 0; j < patent.length; j++) {
                var obj2 = patent[j];
                $("#dynamic_field").append('<tr id="row' + j +
                    '" class="dynamic-added"><td><input type="text" name="fname[]" value="' + (obj2.author_fname || '') + '" placeholder="{{ __("published_research.placeholder.author_fname") }}" class="form-control name_list" /></td><td><input type="text" name="lname[]" value="' + (obj2.author_lname || '') + '" placeholder="{{ __("published_research.placeholder.author_lname") }}" class="form-control name_list" /></td><td><select id="poss' + j + '" class="custom-select my-select" style="width: 200px;" name="pos2[]"><option value="1">{{ __("published_research.pos.first_author") }}</option><option value="2">{{ __("published_research.pos.co_author") }}</option><option value="3">{{ __("published_research.pos.corresponding_author") }}</option></select></td><td><button type="button" name="remove" id="' +
                    j + '" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');
                document.getElementById("poss" + j).value = obj2.pivot?.author_type || obj2.author_type || '';
            }
        }

        $('#add').click(function() {
            j++;
            $('#dynamic_field').append('<tr id="row' + j +
                '" class="dynamic-added"><td><input type="text" name="fname[]" placeholder="{{ __("published_research.placeholder.author_fname") }}" class="form-control name_list" /></td><td><input type="text" name="lname[]" placeholder="{{ __("published_research.placeholder.author_lname") }}" class="form-control name_list" /></td><td><select id="poss' + j + '" class="custom-select my-select" style="width: 200px;" name="pos2[]"><option value="1">{{ __("published_research.pos.first_author") }}</option><option value="2">{{ __("published_research.pos.co_author") }}</option><option value="3">{{ __("published_research.pos.corresponding_author") }}</option></select></td><td><button type="button" name="remove" id="' +
                j + '" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
@endsection
