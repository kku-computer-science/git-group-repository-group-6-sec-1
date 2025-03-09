@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container mt-5">

  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif

  <div class="card">
    <div class="card-body">
        <h4 class="card-title">{{ __('import.import_excel_csv') }}</h4> <!-- แปลหัวข้อ -->
        <form id="import-csv-form" method="POST"  action="{{ url('import') }}" accept-charset="utf-8" enctype="multipart/form-data">
          @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" name="file" placeholder="{{ __('import.choose_file') }}"> <!-- แปล 'เลือกไฟล์' -->
                    </div>
                    @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ __('import.no_file_selected') }}</div>  <!-- แปล 'ไม่ได้เลือกไฟล์ใด' -->
                    @enderror
                </div>               
                 <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-3" id="submit">{{ __('import.submit') }}</button> <!-- แปล 'ยืนยัน' -->
                </div>
            </div>     
        </form>
    </div>
  </div>
</div>

@endsection
