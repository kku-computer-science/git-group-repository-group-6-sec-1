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

        <strong>Whoops!</strong> There were some problems with your input.<br><br>

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
                <h4 class="card-title">แก้ไขรายละเอียดหนังสือ</h4>
                <p class="card-description">กรอกข้อมูลรายละเอียดหนังสือ</p>
                <form class="forms-sample" action="{{ route('books.update',$book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="exampleInputac_name" class="col-sm-3 col-form-label">ชื่อหนังสือ</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_name" value="{{ $book->ac_name }}" class="form-control" placeholder="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_sourcetitle" class="col-sm-3 col-form-label">สถานที่ตีพิมพ์</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_sourcetitle" value="{{ $book->ac_sourcetitle }}" class="form-control" placeholder="สถานที่ตีพิมพ์">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_year" class="col-sm-3 col-form-label">ปีที่เผยแพร่ (พ.ศ.)</label>
                        <div class="col-sm-9">
                            <input type="date" name="ac_year" value="{{ $book->ac_year }}" class="form-control" placeholder="ปีที่เผยแพร่ (พ.ศ.)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_page" class="col-sm-3 col-form-label">จำนวนหน้า (Page)</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_page" value="{{ $book->ac_page }}" class="form-control" placeholder="จำนวนหน้า (Page)">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a class="btn btn-light" href="{{ route('books.index') }}" >Cancel</a>


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
<!-- <form action="{{ route('papers.update',$book->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $book->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $book->detail }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form> -->

</div>
@endsection

