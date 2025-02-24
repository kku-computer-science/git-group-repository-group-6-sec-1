@extends('dashboards.users.layouts.user-dash-layout')
<<<<<<< HEAD
=======

@section('title', __('funds.edit_title'))

>>>>>>> origin/Prommin_1406
@section('content')
<style>
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
<<<<<<< HEAD
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
=======
        <strong>{{ __('funds.confirm_title') }}</strong> {{ __('funds.confirm_text') }}<br><br>
>>>>>>> origin/Prommin_1406
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
<<<<<<< HEAD
                <h4 class="card-title">Edit Fund</h4>
                <p class="card-description">กรอกข้อมูลแก้ไขรายละเอียดทุนงานวิจัย</p>
                <form class="forms-sample" action="{{ route('funds.update',$fund->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <p class="col-sm-3 "><b>ประเภททุนวิจัย</b></p>
                        <!-- <label for="exampleInputfund_type" class="col-sm-2 ">ประเภททุนวิจัย</label> -->
                        <div class="col-sm-4">
                            <select name="fund_type" class="custom-select my-select" id="fund_type" onchange='toggleDropdown(this);' required>
                                <option value="ทุนภายใน" {{ $fund->fund_type == 'ทุนภายใน' ? 'selected' : '' }}>ทุนภายใน</option>
                                <option value="ทุนภายนอก" {{ $fund->fund_type == 'ทุนภายนอก' ? 'selected' : '' }}>ทุนภายนอก</option>
=======
                <h4 class="card-title">{{ __('funds.edit_title') }}</h4>
                <p class="card-description">{{ __('funds.edit_description') }}</p>
                <form class="forms-sample" action="{{ route('funds.update', $fund->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <p class="col-sm-3"><b>{{ __('funds.label.fund_type') }}</b></p>
                        <div class="col-sm-4">
                            <select name="fund_type" class="custom-select my-select" id="fund_type" onchange="toggleDropdown(this);" required>
                                <option value="ทุนภายใน" {{ $fund->fund_type == 'ทุนภายใน' ? 'selected' : '' }}>
                                    {{ __('funds.fund_types.ทุนภายใน') }}
                                </option>
                                <option value="ทุนภายนอก" {{ $fund->fund_type == 'ทุนภายนอก' ? 'selected' : '' }}>
                                    {{ __('funds.fund_types.ทุนภายนอก') }}
                                </option>
>>>>>>> origin/Prommin_1406
                            </select>
                        </div>
                    </div>
                    <div id="fund_code">
                        <div class="form-group row">
<<<<<<< HEAD
                            <p class="col-sm-3"><b>ระดับทุน</b></p>
                            <div class="col-sm-4">
                                <select name="fund_level" class="custom-select my-select">
                                    <option value=""{{ $fund->fund_level == '' ? 'selected' : '' }}>ไม่ระบุ</option>
                                    <option value="สูง" {{ $fund->fund_level == 'สูง' ? 'selected' : '' }}>สูง</option>
                                    <option value="กลาง" {{ $fund->fund_level == 'กลาง' ? 'selected' : '' }}>กลาง</option>
                                    <option value="ล่าง" {{ $fund->fund_level == 'ล่าง' ? 'selected' : '' }}>ล่าง</option>
=======
                            <p class="col-sm-3"><b>{{ __('funds.label.fund_level') }}</b></p>
                            <div class="col-sm-4">
                                <select name="fund_level" class="custom-select my-select">
                                    <option value="" {{ $fund->fund_level == '' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.empty') }}
                                    </option>
                                    <option value="สูง" {{ $fund->fund_level == 'สูง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.สูง') }}
                                    </option>
                                    <option value="กลาง" {{ $fund->fund_level == 'กลาง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.กลาง') }}
                                    </option>
                                    <option value="ล่าง" {{ $fund->fund_level == 'ล่าง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.ล่าง') }}
                                    </option>
>>>>>>> origin/Prommin_1406
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
<<<<<<< HEAD
                        <p class="col-sm-3 "><b>ชื่อทุน</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="fund_name" value="{{ $fund->fund_name }}" class="form-control" placeholder="fund_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-3 "><b>หน่วยงานที่สนับสนุน / โครงการวิจัย</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="support_resource" value="{{ $fund->support_resource }}" class="form-control" placeholder="Support Resource">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Submit</button>
                    <a class="btn btn-light mt-5" href="{{ route('funds.index')}}">Cancel</a>
=======
                        <p class="col-sm-3"><b>{{ __('funds.label.fund_name') }}</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="fund_name" value="{{ $fund->fund_name }}" class="form-control" placeholder="{{ __('funds.label.fund_name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-3"><b>{{ __('funds.label.support_resource') }}</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="support_resource" value="{{ $fund->support_resource }}" class="form-control" placeholder="{{ __('funds.label.support_resource') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">{{ __('funds.submit_button') }}</button>
                    <a class="btn btn-light mt-5" href="{{ route('funds.index') }}">{{ __('funds.cancel_button') }}</a>
>>>>>>> origin/Prommin_1406
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD

=======
>>>>>>> origin/Prommin_1406
</div>

<script>
    const ac = document.getElementById("fund_code");
    const ab = document.getElementById("fund_type").value;
<<<<<<< HEAD
    //console.log(ab);
    if (ab === "ทุนภายนอก") {
        ac.style.display = "none";
    }

    //ac.style.display = "none";

=======
    if (ab === "ทุนภายนอก") {
        ac.style.display = "none";
    }
>>>>>>> origin/Prommin_1406
    function toggleDropdown(selObj) {
        ac.style.display = selObj.value === "ทุนภายใน" ? "block" : "none";
    }
</script>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> origin/Prommin_1406
