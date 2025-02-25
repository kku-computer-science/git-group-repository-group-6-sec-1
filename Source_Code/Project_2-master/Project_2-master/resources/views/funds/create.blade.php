@extends('dashboards.users.layouts.user-dash-layout')



@section('title', __('funds.title'))


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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('funds.add_fund_title') }}</h4>
                <p class="card-description">{{ __('funds.add_fund_description') }}</p>
                <form class="forms-sample" action="{{ route('funds.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="fund_type" class="col-sm-2">{{ __('funds.label.fund_type') }}</label>
                        <div class="col-sm-4">
                            <select name="fund_type" class="custom-select my-select" id="fund_type" onchange="toggleDropdown(this);" required>
                                <option value="" disabled selected>---- {{ __('funds.select_fund_type') }} ----</option>
                                <option value="ทุนภายใน" {{ old('fund_type') == 'ทุนภายใน' ? 'selected' : '' }}>
                                    {{ __('funds.fund_types.ทุนภายใน') }}
                                </option>
                                <option value="ทุนภายนอก" {{ old('fund_type') == 'ทุนภายนอก' ? 'selected' : '' }}>
                                    {{ __('funds.fund_types.ทุนภายนอก') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="fund_code">
                        <div class="form-group row">
                            <label for="fund_level" class="col-sm-2">{{ __('funds.label.fund_level') }}</label>
                            <div class="col-sm-4">
                                <select name="fund_level" class="custom-select my-select">
                                    <option value="" disabled selected>---- {{ __('funds.select_fund_level') }} ----</option>
                                    <option value="">{{ __('funds.fund_levels.empty') }}</option>
                                    <option value="สูง" {{ old('fund_level') == 'สูง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.สูง') }}
                                    </option>
                                    <option value="กลาง" {{ old('fund_level') == 'กลาง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.กลาง') }}
                                    </option>
                                    <option value="ล่าง" {{ old('fund_level') == 'ล่าง' ? 'selected' : '' }}>
                                        {{ __('funds.fund_levels.ล่าง') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fund_name" class="col-sm-2">{{ __('funds.label.fund_name') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="fund_name" class="form-control" placeholder="{{ __('funds.placeholder.fund_name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="support_resource" class="col-sm-2">{{ __('funds.label.support_resource') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="support_resource" class="form-control" placeholder="{{ __('funds.placeholder.support_resource') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{ __('funds.submit_button') }}</button>
                    <a class="btn btn-light" href="{{ route('funds.index') }}">{{ __('funds.cancel_button') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const ac = document.getElementById("fund_code");
    function toggleDropdown(selObj) {
        ac.style.display = selObj.value === "ทุนภายใน" ? "block" : "none";
    }
</script>
@endsection
