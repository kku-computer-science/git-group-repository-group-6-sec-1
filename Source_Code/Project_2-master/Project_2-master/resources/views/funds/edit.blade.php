@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('funds.edit_title'))

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
        <strong>{{ __('funds.confirm_title') }}</strong> {{ __('funds.confirm_text') }}<br><br>
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
                            </select>
                        </div>
                    </div>
                    <div id="fund_code">
                        <div class="form-group row">
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
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
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
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const ac = document.getElementById("fund_code");
    const ab = document.getElementById("fund_type").value;
    if (ab === "ทุนภายนอก") {
        ac.style.display = "none";
    }
    function toggleDropdown(selObj) {
        ac.style.display = selObj.value === "ทุนภายใน" ? "block" : "none";
    }
</script>
@endsection
