@extends('dashboards.users.layouts.user-dash-layout')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>



@section('title', __('books.title'))
@section('content')
<style type="text/css">
    .dropdown-toggle {
        height: 40px;
        width: 80px !important;
    }


    .my-select {
        background-color: #fff;
        color: #212529;
        border: 0.2px solid #000;
        border-radius: 5px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="pull-right">

            </div>

            <!-- สามารถเพิ่ม breadcrumb หรือ header ได้ตามต้องการ -->

        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">

        <strong>Whoops!</strong> There were some problems with your input.<br><br>

        <strong>{{ __('books.error_title') }}</strong> {{ __('books.error_text') }}<br><br>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- <a class="btn btn-primary" href="{{ route('books.index') }}"> Back </a> -->


    <div class="col-md-8 grid-margin stretch-card">
        <div class="card" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('books.add_button') }} {{ __('books.title') }}</h4>
                <p class="card-description">{{ __('books.card_description') }}</p>
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <!-- Book Name -->
                    <div class="form-group row">
                        <label for="ac_name" class="col-sm-3 col-form-label">{{ __('books.book_name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_name" class="form-control" placeholder="{{ __('books.book_name') }}">
                        </div>
                    </div>
                    <!-- Publication (Source Title) -->
                    <div class="form-group row">
                        <label for="ac_sourcetitle" class="col-sm-3 col-form-label">{{ __('books.publication') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_sourcetitle" class="form-control" placeholder="{{ __('books.publication') }}">
                        </div>
                    </div>
                    <!-- Year -->
                    <div class="form-group row">
                        <label for="ac_year" class="col-sm-3 col-form-label">{{ __('books.year') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="ac_year" class="form-control" placeholder="{{ __('books.year') }}">
                        </div>
                    </div>
                    <!-- Page -->
                    <div class="form-group row">
                        <label for="ac_page" class="col-sm-3 col-form-label">{{ __('books.page') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_page" class="form-control" placeholder="{{ __('books.page') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{ __('books.submit_button') }}</button>
                    <a class="btn btn-light" href="{{ route('books.index') }}">{{ __('books.cancel_button') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var postURL = "<?php echo url('addmore'); ?>";
        var i = 1;


        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');
        });


        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#submit').click(function() {
            $.ajax({
                url: postURL,
                method: "POST",
                data: $('#add_name').serialize(),
                type: 'json',
                success: function(data) {
                    if (data.error) {
                        printErrorMsg(data.error);
                    } else {
                        i = 1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display', 'block');
                        $(".print-error-msg").css('display', 'none');
                        $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                    }
                }
            });
        });


        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $(".print-success-msg").css('display', 'none');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    });
</script>
@endsection
<!-- <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="paper_name" class="form-control" placeholder="paper_name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Year:</strong>
                    <textarea class="form-control" style="height:150px" name="paper_year" placeholder="paper_year"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>paper_type:</strong>
                    <textarea class="form-control" style="height:150px" name="paper_type" placeholder="paper_type"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>paper_level:</strong>
                    <textarea class="form-control" style="height:150px" name="paper_level" placeholder="paper_level"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>paper_details:</strong>
                    <textarea class="form-control" style="height:150px" name="paper_details" placeholder="paper_details"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
</div> -->
