@extends('dashboards.users.layouts.user-dash-layout')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@section('title', __('books.title'))
@section('content')
<style type="text/css">
    .dropdown-toggle {
        height: 40px;
        width: 400px !important;
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
            <!-- สามารถเพิ่ม breadcrumb หรือ header ได้ตามต้องการ -->
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('books.error_title') }}</strong> {{ __('books.error_text') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
        // ถ้ามีโค้ด JavaScript เพิ่มเติมให้ใส่ที่นี่
    });
</script>
@endsection
