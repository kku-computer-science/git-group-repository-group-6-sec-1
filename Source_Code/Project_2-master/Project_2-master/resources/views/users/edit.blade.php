@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ __('users.error_title') }}</strong> {{ __('users.error_message') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card col-8" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('users.edit_title') }}</h4>
                <p class="card-description">{{ __('users.edit_description') }}</p>
                {!! Form::model($user, ['route' => ['users.update', $user->id], 'method'=>'PATCH']) !!}

                <div class="form-group row">
                    <div class="col-sm-6">
                        <p><b>{{ __('users.first_name_th') }}</b></p>
                            {!! Form::text('fname_th', null, array('placeholder' => __('users.first_name_th'),'class' => 'form-control')) !!}
                    </div>
                    <div class="col-sm-6">
                            <p><b>{{ __('users.last_name_th') }}</b></p>
                            {!! Form::text('lname_th', null, array('placeholder' => __('users.last_name_th'),'class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <p><b>{{ __('users.fname_en') }}</b></p>
                        <input type="text" name="fname_en" value="{{ $user->fname_en }}" class="form-control" placeholder="{{ __('users.fname_en_placeholder') }}">
                    </div>
                    <div class="col-sm-6">
                        <p><b>{{ __('users.lname_en') }}</b></p>
                        <input type="text" name="lname_en" value="{{ $user->lname_en }}" class="form-control" placeholder="{{ __('users.lname_en_placeholder') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.email') }}</b></p>
                    <div class="col-sm-8">
                        <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.password') }}</b></p>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.confirm_password') }}</b></p>
                    <div class="col-sm-8">
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.academic_ranks') }}</b></p>
                    <div class="col-sm-8">
                        <!-- Academic Rank in English -->
                        <select id="academic_ranks_en" name="academic_ranks_en" class="form-control">
                            <option value="">{{ __('users.academic_ranks') }}</option>
                            <option value="Lecturer" {{ $user->academic_ranks_en == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                            <option value="Assistant Professor" {{ $user->academic_ranks_en == 'Assistant Professor' ? 'selected' : '' }}>Assistant Professor</option>
                            <option value="Associate Professor" {{ $user->academic_ranks_en == 'Associate Professor' ? 'selected' : '' }}>Associate Professor</option>
                            <option value="Professor" {{ $user->academic_ranks_en == 'Professor' ? 'selected' : '' }}>Professor</option>
                        </select>

                        <!-- Academic Rank in Thai -->
                        <input type="text" id="academic_ranks_th" name="academic_ranks_th" class="form-control mt-2"
                            value="{{ $user->academic_ranks_th }}"
                            placeholder="{{ __('academic_rank') }} (ภาษาไทย)" readonly>

                        <!-- Academic Rank in Chinese -->
                        <input type="text" id="academic_ranks_zh" name="academic_ranks_zh" class="form-control mt-2"
                            value="{{ $user->academic_ranks_zh }}"
                            placeholder="{{ __('academic_rank') }} (中文)" readonly>
                    </div>
                </div>
                                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.role') }}</b></p>
                    <div class="col-sm-8">
                        {!! Form::select('roles[]', $roles, $userRole, array('class' => 'selectpicker','multiple data-live-search'=>"true")) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('users.status') }}</b></p>
                    <div class="col-sm-8">
                        <select id='status' class="form-control" style='width: 200px;' name="status">
                            <option value="1" {{ "1" == $user->status ? 'selected' : '' }}>{{ __('users.status_studying') }}</option>
                            <option value="2" {{ "2" == $user->status ? 'selected' : '' }}>{{ __('users.status_graduated') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <p for="category"><b>{{ __('users.department') }} <span class="text-danger">*</span></b></p>
                        <select class="form-control" name="cat" id="cat" style="width: 100%;" required>
                            <option>{{ __('users.select_department') }}</option>
                            @foreach ($departments as $cat)
                                <option value="{{$cat->id}}" {{$user->program->department_id == $cat->id  ? 'selected' : ''}}>
                                    <!-- Dynamically show the department name based on the selected language -->
                                    @switch(app()->getLocale())
                                        @case('th')
                                            {{ $cat->department_name_th }}
                                            @break
                                        @case('zh')
                                            {{ $cat->department_name_zh }}
                                            @break
                                        @default
                                            {{ $cat->department_name_en }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-6">
                        <p for="category"><b>{{ __('users.program') }} <span class="text-danger">*</span></b></p>
                        <select class="form-control select2" name="sub_cat" id="subcat" required>
                            <option>{{ __('users.select_program') }}</option>
                            @foreach ($programs as $cat)
                                <option value="{{$cat->id}}" {{$user->program->id == $cat->id ? 'selected' : ''}}>
                                    <!-- Dynamically show the program name based on the selected language -->
                                    @switch(app()->getLocale())
                                        @case('th')
                                            {{ $cat->program_name_th }}
                                            @break
                                        @case('zh')
                                            {{ $cat->program_name_zh }}
                                            @break
                                        @default
                                            {{ $cat->program_name_en }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
<!-- Education Form  -->
                <h4><b>{{ __('users.education') }}</b></h4>

<ul class="nav nav-tabs" id="educationTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="bachelor-tab" data-toggle="tab" href="#bachelor" role="tab">{{ __('users.bachelor') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="master-tab" data-toggle="tab" href="#master" role="tab">{{ __('users.master') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="doctoral-tab" data-toggle="tab" href="#doctoral" role="tab">{{ __('users.doctoral') }}</a>
    </li>
</ul>

<div class="tab-content" id="educationTabContent">
    <!-- Bachelor Form -->
    <div class="tab-pane fade show active" id="bachelor" role="tabpanel">
    <div class="form-group">
        <label><b>{{ __('users.university_name') }}</b></label>
        <div class="col-sm-8">
            <input type="text" name="bachelor_university_th" class="form-control" 
                placeholder="{{ __('users.university_name_th') }}" 
                value="{{ $education->where('level', '1')->first()->uname ?? '' }}">
            <input type="text" name="bachelor_university_en" class="form-control" 
                placeholder="{{ __('users.university_name_en') }}" 
                value="{{ $education->where('level', '1')->first()->university_en ?? '' }}">
            <input type="text" name="bachelor_university_cn" class="form-control" 
                placeholder="{{ __('users.university_name_cn') }}" 
                value="{{ $education->where('level', '1')->first()->university_zh ?? '' }}">
        </div>
    </div>

        <div class="form-group">
            <p class="col-sm-3"><b>{{ __('users.degree_full') }}</b></p>
            <div class="col-sm-8">
                <input type="text" name="bachelor_degree_th" class="form-control" 
                    placeholder="{{ __('users.degree_full_th') }}" 
                    value="{{ $education->where('level', '1')->first()->qua_name ?? '' }}">
                <input type="text" name="bachelor_degree_en" class="form-control" 
                    placeholder="{{ __('users.degree_full_en') }}" 
                    value="{{ $education->where('level', '1')->first()->qua_name_en ?? '' }}">
                <input type="text" name="bachelor_degree_cn" class="form-control" 
                    placeholder="{{ __('users.degree_full_cn') }}" 
                    value="{{ $education->where('level', '1')->first()->qua_name_zh ?? '' }}">
            </div>
        </div>

        <div class="form-group">
            <p class="col-sm-3"><b>{{ __('users.graduation_year') }}</b></p>
            <div class="col-sm-8">
                <!-- Bachelor's Year in Thai -->
                <input type="text" id="bachelor_year_th" name="bachelor_year_th" class="form-control" 
                    placeholder="{{ __('users.degree_full_th') }}" 
                    value="{{ $education->where('level', '1')->first()->year ?? '' }}"
                    oninput="updateYears('bachelor')">

                <!-- Bachelor's Year in English, auto-filled with 'year-543' and non-editable -->
                <input type="text" id="bachelor_year_en" name="bachelor_year_en" class="form-control" 
                    placeholder="{{ __('users.degree_full_en') }}" 
                    value="{{ $education->where('level', '1')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
                    readonly>

                <!-- Bachelor's Year in Chinese, auto-filled with 'year-543' and non-editable -->
                <input type="text" id="bachelor_year_cn" name="bachelor_year_cn" class="form-control" 
                    placeholder="{{ __('users.degree_full_cn') }}" 
                    value="{{ $education->where('level', '1')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
                    readonly>
            </div>
        </div>

    </div>


    <!-- Master Form -->
    <div class="tab-pane fade show active" id="master" role="tabpanel">
    <div class="form-group">
        <label><b>{{ __('users.university_name') }}</b></label>
        <div class="col-sm-8">
            <input type="text" name="master_university_th" class="form-control" 
                placeholder="{{ __('users.university_name_th') }}" 
                value="{{ $education->where('level', '2')->first()->uname ?? '' }}">
            <input type="text" name="master_university_en" class="form-control" 
                placeholder="{{ __('users.university_name_en') }}" 
                value="{{ $education->where('level', '2')->first()->university_en ?? '' }}">
            <input type="text" name="master_university_cn" class="form-control" 
                placeholder="{{ __('users.university_name_cn') }}" 
                value="{{ $education->where('level', '2')->first()->university_zh ?? '' }}">
        </div>
    </div>

        <div class="form-group">
            <p class="col-sm-3"><b>{{ __('users.degree_full') }}</b></p>
            <div class="col-sm-8">
                <input type="text" name="master_degree_th" class="form-control" 
                    placeholder="{{ __('users.degree_full_th') }}" 
                    value="{{ $education->where('level', '2')->first()->qua_name ?? '' }}">
                <input type="text" name="master_degree_en" class="form-control" 
                    placeholder="{{ __('users.degree_full_en') }}" 
                    value="{{ $education->where('level', '2')->first()->qua_name_en ?? '' }}">
                <input type="text" name="master_degree_cn" class="form-control" 
                    placeholder="{{ __('users.degree_full_cn') }}" 
                    value="{{ $education->where('level', '2')->first()->qua_name_zh ?? '' }}">
            </div>
        </div>

<!-- Master's Degree Form Group -->
<div class="form-group">
    <p class="col-sm-3"><b>{{ __('users.graduation_year') }}</b></p>
    <div class="col-sm-8">
        <!-- Master's Year in Thai -->
        <input type="text" id="master_year_th" name="master_year_th" class="form-control" 
            placeholder="{{ __('users.degree_full_th') }}" 
            value="{{ $education->where('level', '2')->first()->year ?? '' }}" 
            oninput="updateYears('master')">

        <!-- Master's Year in English -->
        <input type="text" id="master_year_en" name="master_year_en" class="form-control" 
            placeholder="{{ __('users.degree_full_en') }}" 
            value="{{ $education->where('level', '2')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
            readonly>

        <!-- Master's Year in Chinese -->
        <input type="text" id="master_year_cn" name="master_year_cn" class="form-control" 
            placeholder="{{ __('users.degree_full_cn') }}" 
            value="{{ $education->where('level', '2')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
            readonly>
    </div>
</div>

    </div>

    <!-- Doctoral Form -->

    <div class="tab-pane fade show active" id="doctoral" role="tabpanel">
    <div class="form-group">
        <label><b>{{ __('users.university_name') }}</b></label>
        <div class="col-sm-8">
            <input type="text" name="doctoral_university_th" class="form-control" 
                placeholder="{{ __('users.university_name_th') }}" 
                value="{{ $education->where('level', '3')->first()->uname ?? '' }}">
            <input type="text" name="doctoral_university_en" class="form-control" 
                placeholder="{{ __('users.university_name_en') }}" 
                value="{{ $education->where('level', '3')->first()->university_en ?? '' }}">
            <input type="text" name="doctoral_university_cn" class="form-control" 
                placeholder="{{ __('users.university_name_cn') }}" 
                value="{{ $education->where('level', '3')->first()->university_zh ?? '' }}">
        </div>
    </div>

        <div class="form-group">
            <p class="col-sm-3"><b>{{ __('users.degree_full') }}</b></p>
            <div class="col-sm-8">
                <input type="text" name="doctoral_degree_th" class="form-control" 
                    placeholder="{{ __('users.degree_full_th') }}" 
                    value="{{ $education->where('level', '3')->first()->qua_name ?? '' }}">
                <input type="text" name="doctoral_degree_en" class="form-control" 
                    placeholder="{{ __('users.degree_full_en') }}" 
                    value="{{ $education->where('level', '3')->first()->qua_name_en ?? '' }}">
                <input type="text" name="doctoral_degree_cn" class="form-control" 
                    placeholder="{{ __('users.degree_full_cn') }}" 
                    value="{{ $education->where('level', '3')->first()->qua_name_zh ?? '' }}">
            </div>
        </div>

        <div class="form-group">
            <p class="col-sm-3"><b>{{ __('users.graduation_year') }}</b></p>
            <div class="col-sm-8">
                <!-- Doctoral Year in Thai -->
                <input type="text" id="doctoral_year_th" name="doctoral_year_th" class="form-control" 
                    placeholder="{{ __('users.degree_full_th') }}" 
                    value="{{ $education->where('level', '3')->first()->year ?? '' }}"
                    oninput="updateYears('doctoral')">
                
                <!-- Doctoral Year in English, auto-filled with 'year-543' and non-editable -->
                <input type="text" id="doctoral_year_en" name="doctoral_year_en" class="form-control" 
                    placeholder="{{ __('users.degree_full_en') }}" 
                    value="{{ $education->where('level', '3')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
                    readonly>
                
                <!-- Doctoral Year in Chinese, auto-filled with 'year-543' and non-editable -->
                <input type="text" id="doctoral_year_cn" name="doctoral_year_cn" class="form-control" 
                    placeholder="{{ __('users.degree_full_cn') }}" 
                    value="{{ $education->where('level', '3')->first()->year_anno_domino ?? (date('Y') + 543) }}" 
                    readonly>
            </div>
        </div>


    </div>

</div>


                <button type="submit" class="btn btn-primary mt-5">{{ __('users.submit') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('users.index') }}">{{ __('users.cancel') }}</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script>
    $('#cat').on('change', function(e) {
        var cat_id = e.target.value;
        $.get('/ajax-get-subcat?cat_id=' + cat_id, function(data) {
            $('#subcat').empty();
            $.each(data, function(index, areaObj) {
                $('#subcat').append('<option value="' + areaObj.id + '" >' + areaObj
                    .program_name_en + '</option>');
            });
        });
    });

    function updateYears(level) {
    // Get the Thai year value
    let yearTh = document.getElementById(`${level}_year_th`).value;

    // Validate if the year is in the correct format (e.g., numeric and valid)
    if (yearTh) {
        // Convert Thai year to Gregorian year (Thai year is 543 years ahead of Gregorian year)
        let gregorianYear = yearTh - 543;

        // Update the English and Chinese year fields dynamically
        document.getElementById(`${level}_year_en`).value = gregorianYear;
        document.getElementById(`${level}_year_cn`).value = gregorianYear;
    }
}

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rankMap = {
            "Lecturer": { "en": "Lecturer", "th": "อาจารย์", "zh": "讲师" },
            "Assistant Professor": { "en": "Assistant Professor", "th": "ผู้ช่วยศาสตราจารย์", "zh": "助理教授" },
            "Associate Professor": { "en": "Associate Professor", "th": "รองศาสตราจารย์", "zh": "副教授" },
            "Professor": { "en": "Professor", "th": "ศาสตราจารย์", "zh": "教授" }
        };

        // Get Laravel locale
        const currentLocale = "{{ app()->getLocale() }}";

        const langPlaceholders = {
            "en": {
                "academic_ranks_en": "{{ __('users.academic_rank') }} (English)",
                "academic_ranks_th": "{{ __('users.academic_rank') }} (Thai)",
                "academic_ranks_zh": "{{ __('users.academic_rank') }} (Chinese)"
            },
            "th": {
                "academic_ranks_en": "{{ __('users.academic_rank') }} (ภาษาอังกฤษ)",
                "academic_ranks_th": "{{ __('users.academic_rank') }} (ภาษาไทย)",
                "academic_ranks_zh": "{{ __('users.academic_rank') }} (ภาษาจีน)"
            },
            "zh": {
                "academic_ranks_en": "{{ __('users.academic_rank') }} (英语)",
                "academic_ranks_th": "{{ __('users.academic_rank') }} (泰语)",
                "academic_ranks_zh": "{{ __('users.academic_rank') }} (中文)"
            }
        };

        const selectEn = document.getElementById("academic_ranks_en");
        const inputTh = document.getElementById("academic_ranks_th");
        const inputZh = document.getElementById("academic_ranks_zh");

        function updateRanks() {
            let selectedRank = selectEn.value;
            inputTh.value = rankMap[selectedRank]?.th || "";
            inputZh.value = rankMap[selectedRank]?.zh || "";
        }

        function updatePlaceholders() {
            if (langPlaceholders[currentLocale]) {
                inputTh.setAttribute("placeholder", langPlaceholders[currentLocale]["academic_ranks_th"]);
                inputZh.setAttribute("placeholder", langPlaceholders[currentLocale]["academic_ranks_zh"]);
            }
        }

        // Update ranks when selecting an English rank
        selectEn.addEventListener("change", updateRanks);

        // Auto-fill if user already has a rank
        if (selectEn.value) {
            updateRanks();
        }

        // Set placeholders based on current language
        updatePlaceholders();
    });
</script>



<style>
/* Styling for better readability */
.nav-tabs .nav-link {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.nav-tabs .nav-link.active {
    background-color: #007bff;
    color: #fff !important;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    font-size: 14px;
    color: #555;
}

input[type="text"] {
    margin-top: 5px;
    padding: 8px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.tab-pane {
    padding: 20px;
    border: 1px solid #ddd;
    border-top: none;
    background: #f9f9f9;
    border-radius: 0 0 5px 5px;
}

h4 {
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: bold;
    color: #444;
}

@media (max-width: 768px) {
    .nav-tabs .nav-item {
        width: 100%;
        text-align: center;
    }
    
    input[type="text"] {
        font-size: 14px;
    }
}

</style>


@endsection