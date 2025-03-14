@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('books.edit_title'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <!-- Header or breadcrumb (ถ้ามี) -->
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
                <h4 class="card-title">{{ __('books.edit_title') }}</h4>
                <p class="card-description">{{ __('books.card_description') }}</p>
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Book Name -->
                    <div class="form-group row">
                        <label for="ac_name" class="col-sm-3 col-form-label">{{ __('books.book_name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_name" value="{{ $book->ac_name }}" class="form-control" placeholder="{{ __('books.book_name') }}">
                        </div>
                    </div>
                    <!-- Publication (Source Title) -->
                    <div class="form-group row">
                        <label for="ac_sourcetitle" class="col-sm-3 col-form-label">{{ __('books.publication') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_sourcetitle" value="{{ $book->ac_sourcetitle }}" class="form-control" placeholder="{{ __('books.publication') }}">
                        </div>
                    </div>
                    <!-- Year -->
                    <div class="form-group row">
                        <label for="ac_year" class="col-sm-3 col-form-label">{{ __('books.year') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="ac_year" value="{{ $book->ac_year }}" class="form-control" placeholder="{{ __('books.year') }}">
                        </div>
                    </div>
                    <!-- Page -->
                    <div class="form-group row">
                        <label for="ac_page" class="col-sm-3 col-form-label">{{ __('books.page') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_page" value="{{ $book->ac_page }}" class="form-control" placeholder="{{ __('books.page') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">{{ __('books.submit_button') }}</button>
                    <a class="btn btn-light" href="{{ route('books.index') }}">{{ __('books.cancel_button') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection