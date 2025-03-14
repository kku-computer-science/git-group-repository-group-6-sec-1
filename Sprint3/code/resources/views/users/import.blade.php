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
                  <!-- Hidden file input -->
                  <input type="file" name="file" id="file" style="display: none;" onchange="updateFileName()">
                  
                  <!-- Button acting as file chooser with plain HTML styling -->
                  <button type="button" onclick="document.getElementById('file').click()" style="padding: 10px 20px; background-color:rgb(173, 173, 173); color: white; border: none; border-radius: 5px; cursor: pointer;">
                      {{ __('import.choose_file') }}
                  </button>
                  
                  <!-- Optional: Show file name after selecting a file -->
                  <div id="file-name" class="mt-2"></div>
              </div>

              @error('file')
                  <div class="alert alert-danger mt-1 mb-1">{{ __('import.no_file_selected') }}</div>
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

<script>
    // Function to display selected file name (optional)
    function updateFileName() {
        var fileInput = document.getElementById('file');
        var fileName = fileInput.files[0] ? fileInput.files[0].name : '';
        document.getElementById('file-name').innerText = fileName;
    }
</script>

@endsection
