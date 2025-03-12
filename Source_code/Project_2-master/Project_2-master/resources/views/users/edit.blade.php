@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<script>
    var userId = {{ $user->id }};
</script>

<div class="container">
    <div class="justify-content-center">
        <div class="card col-8" style="padding: 16px;">
            <div class="card-body">
                <h4 class="card-title">{{ __('users.edit_title') }}</h4>
                <p class="card-description">{{ __('users.edit_description') }}</p>
                {!! Form::model($user, ['route' => ['users.update', $user->id], 'method'=>'PATCH']) !!}

                

            <!-- <div class="p-4">
                <div class="img-circle text-center mb-3">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle admin_picture" src="{{ Auth::user()->picture }}" alt="{{ trans('reference.profile') }} picture">
                    </div>
                    <h4 class="text-center p-2">{{ Auth::user()->{'fname_'.app()->getLocale()} }} {{ Auth::user()->{'lname_'.app()->getLocale()} }}</h4>
                    <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block btn-sm" id="change_picture_btn"><b>{{ trans('reference.change_picture') }}</b></a>
                </div>
            </div> -->

            <div class="p-4">
                <div class="img-circle text-center mb-3">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle user_picture" src="{{ $user->picture }}" alt="###">
                    </div>
                    <h4 class="text-center p-2">
                        @if(app()->getLocale() == 'zh')
                            {{ $user->fname_en }} {{ $user->lname_en }}
                        @else
                            {{ $user->{'fname_' . app()->getLocale()} }} {{ $user->{'lname_' . app()->getLocale()} }}
                        @endif
                    </h4>

                    
                    <!-- Hidden elements for cropping -->
                    <div id="croppr-container" style="display: none; margin: 20px auto;">
                        <img id="croppr-image" src="" style="max-width: 100%;">
                    </div>
                    
                    <input type="file" name="user_image" id="user_image" style="opacity: 0;height:1px;display:none">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block btn-sm" id="change_picture_btn"><b>{{ trans('reference.change_picture') }}</b></a>
                    
                    <!-- Add a save button that will appear when cropping -->
                    <button type="button" id="save_crop_btn" class="btn btn-success btn-block btn-sm" style="display: none;"><b>{{ trans('reference.save_image') }}</b></button>
                </div>
            </div>
            


                <div class="form-group row">
                    <div class="col-sm-6">
                        <select name="title_name_{{ app()->getLocale() }}" class="form-control">
                            <option value="" disabled selected>{{ __('users.name_title') }}</option>
                            @foreach ($titles as $title)
                                <option value="{{ $title }}" {{ old('title_name_' . app()->getLocale(), $user->{'title_name_' . app()->getLocale()}) == $title ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>





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

                @if(Auth::user()->email === 'admin@gmail.com')
                    <form action="{{ route('admin.updateUserPassword', $user->id) }}" method="POST">
                        @csrf
                        <h4 class="mb-4">{{ trans('reference.change_user_password') }}</h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('reference.new_password') }}</label>
                                    <input type="password" class="form-control" name="newpassword" placeholder="Enter new password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('reference.confirm_new_password') }}</label>
                                    <input type="password" class="form-control" name="newpassword_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ trans('reference.update_password') }}</button>
                    </form>
                    @endif


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

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Include Croppr CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/croppr/dist/croppr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/croppr/dist/croppr.min.js"></script>>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>



</script>

<script>
$(document).ready(function() {
    let croppr;
    let fileReader = new FileReader();
    let selectedFile;
    
    // When change picture button is clicked
    $(document).on('click', '#change_picture_btn', function() {
        $('#user_image').click();
    });
    
    // When a file is selected
    $('#user_image').on('change', function(e) {
        selectedFile = e.target.files[0];
        
        if (!selectedFile) return;
        
        // Check file extension
        const allowedExtensions = ['jpg', 'jpeg', 'png'];
        const extension = selectedFile.name.split('.').pop().toLowerCase();
        
        if (!allowedExtensions.includes(extension)) {
            alert('Only JPG, JPEG, and PNG files are allowed');
            return;
        }
        
        // Read the file and show the cropper
        fileReader.readAsDataURL(selectedFile);
    });
    
    fileReader.onload = function(e) {
        // Show the cropper container
        $('#croppr-container').show();
        $('#croppr-image').attr('src', e.target.result);
        $('#save_crop_btn').show();
        
        // Hide the change picture button temporarily
        $('#change_picture_btn').hide();
        
        // Initialize Croppr with 2:3 aspect ratio
        if (croppr) {
            croppr.destroy();
        }
        
        croppr = new Croppr('#croppr-image', {
            aspectRatio: 16/9,
            onInitialize: function(value) {},
            onCropStart: function(value) {},
            onCropMove: function(value) {},
            onCropEnd: function(value) {}
        });
    };
    
    // When save button is clicked
    $('#save_crop_btn').on('click', function() {
        if (!croppr) return;
        
        const cropData = croppr.getValue();
        
        // Create a FormData object to send the file and crop coordinates
        const formData = new FormData();
        formData.append('user_image', selectedFile);
        formData.append('x', cropData.x);
        formData.append('y', cropData.y);
        formData.append('width', cropData.width);
        formData.append('height', cropData.height);
        
        // Send the data to the server
        $.ajax({
    url: '/admin/user-picture-update/' + userId,  // Now userId is defined
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.status === 1) {
            Swal.fire("Success", "User picture updated successfully", "success");
            $('.user_picture').attr('src', '/images/imag_user/' + response.filename);
        } else {
            alert(response.msg);
        }
    },
    error: function(xhr) {
        alert('Error: ' + xhr.responseText);
        console.error(xhr.responseText);
    }
});


            });
});
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

<script>
    $(document).ready(function() {
        $('#adminUpdatePasswordForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status === 1) {
                        Swal.fire({
                            title: "{{ trans('reference.update_password_success') }}",
                            text: response.msg,
                            icon: "success"
                        });
                        $('#adminUpdatePasswordForm')[0].reset();
                    } else {
                        Swal.fire("Error", response.msg, "error");
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Validation errors
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('span.' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire("Error", "Something went wrong: " + xhr.responseText, "error");
                    }
                }
            });
        });
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
.image-preview {
        max-width: 150px;
        max-height: 150px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 50%; /* ทำให้เป็นวงกลมเหมือนตัวอย่าง */
    }

    .btn-rounded {
    border-radius: 25px;
    padding: 8px 20px;
    transition: all 0.3s ease;
}

.btn-rounded:hover {
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
    transform: scale(1.05);
}
</style>

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .btn {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
    }

    .error-text {
        font-size: 0.9rem;
    }
</style>



<style>
    .profile-user-img {
        width: 150px; /* Fixed width */
        height: 150px; /* Fixed height */
        object-fit: cover; /* Ensures the image fits nicely without distortion */
        border: 3px solid #ddd; /* Optional: adds a subtle border */
        transition: transform 0.3s ease; /* Smooth hover effect */
    }

    .profile-user-img:hover {
        transform: scale(1.05); /* Slight zoom on hover */
    }

    .btn-custom {
        background-color: #007bff; /* Bootstrap primary color */
        border-radius: 25px; /* Rounded corners */
        padding: 10px 20px; /* Larger padding for a bigger button */
        font-weight: 500; /* Slightly bolder text */
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); /* Soft shadow */
        transition: all 0.3s ease; /* Smooth transitions */
    }

    .btn-custom:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-2px); /* Lift effect */
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5); /* Stronger shadow on hover */
    }

    .btn-custom i {
        vertical-align: middle; /* Aligns icon with text */
    }

    .profile-user-img {
    width: 180px;
    height: 320px;
    object-fit: cover;
    border: 3px solid #ddd;
    transition: transform 0.3s ease;
}
</style>


@endsection