@extends('dashboards.users.layouts.user-dash-layout')

@section('content')

@php
    $titles = [
        'th' => ['นาย', 'นาง', 'นางสาว'],
        'en' => ['Mr.', 'Mrs.', 'Miss'],
        'zh' => ['先生', '太太', '小姐']
    ];
    $locale = app()->getLocale(); // Get current language
@endphp

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
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
                    <h4 class="card-title mb-5">{{ __('users.add_user') }}</h4>
                    <p class="card-description">{{ __('users.user_details') }}</p>
                    {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
                

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <p><b>{{ __('users.name_title') }}</b></p>
                            <select name="title_name_{{ $locale }}" class="form-control">
                                <option value="" disabled selected>{{ __('users.name_title') }}</option>
                                @foreach ($titles[$locale] as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <p><b>{{ __('users.first_name_th') }}</b></p>
                                {!! Form::text('fname_th', null, ['placeholder' => __('users.first_name_th'), 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-sm-6">
                                <p><b>{{ __('users.last_name_th') }}</b></p>
                                {!! Form::text('lname_th', null, ['placeholder' => __('users.last_name_th'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <p><b>{{ __('users.first_name_en') }}</b></p>
                                {!! Form::text('fname_en', null, ['placeholder' => __('users.first_name_en'), 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-sm-6">
                                <p><b>{{ __('users.last_name_en') }}</b></p>
                                {!! Form::text('lname_en', null, ['placeholder' => __('users.last_name_en'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <p><b>{{ __('users.email') }}</b></p>
                                {!! Form::text('email', null, ['placeholder' => __('users.email'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <p><b>{{ __('users.password') }}:</b></p>
                                {!! Form::password('password', ['placeholder' => __('users.password'), 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-sm-6">
                                <p><b>{{ __('users.confirm_password') }}:</b></p>
                                {!! Form::password('password_confirmation', ['placeholder' => __('users.confirm_password'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-8">
                            <p><b>{{ __('users.role') }}:</b></p>
                            <div class="col-sm-8">
                                {!! Form::select('roles[]', $roles, [], [
                                    'class' => 'selectpicker',
                                    'multiple',
                                    'data-none-selected-text' => __('users.select_category')
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3"><b>{{ __('users.academic_ranks') }}</b></p>
                            <div class="col-sm-8">
                                <!-- Academic Rank in English -->
                                <select id="academic_ranks_en" name="academic_ranks_en" class="form-control">
                                    <option value="">{{ App::getLocale() == 'th' ? 'ตำแหน่งทางวิชาการ (ภาษาอังกฤษ)' : (App::getLocale() == 'zh' ? '学术头衔 (英文)' : 'Academic Rank (English)') }}</option>
                                    <option value="Lecturer" {{ old('academic_ranks_en') == 'Lecturer' ? 'selected' : '' }}>
                                        Lecturer
                                    </option>
                                    <option value="Assistant Professor" {{ old('academic_ranks_en') == 'Assistant Professor' ? 'selected' : '' }}>
                                        Assistant Professor
                                    </option>
                                    <option value="Associate Professor" {{ old('academic_ranks_en') == 'Associate Professor' ? 'selected' : '' }}>
                                        Associate Professor <!-- แก้ typo จาก "Asassociate" เป็น "Associate" -->
                                    </option>
                                    <option value="Professor" {{ old('academic_ranks_en') == 'Professor' ? 'selected' : '' }}>
                                        Professor
                                    </option>
                                </select>

                                <!-- Academic Rank in Thai -->
                                <input type="text" id="academic_ranks_th" name="academic_ranks_th" class="form-control mt-2"
                                    value="{{ old('academic_ranks_th') }}"
                                    placeholder="{{ App::getLocale() == 'th' ? 'ตำแหน่งทางวิชาการ (ภาษาไทย)' : (App::getLocale() == 'zh' ? '学术头衔 (泰语)' : 'Academic Rank (Thai)') }}"
                                    readonly>

                                <!-- Academic Rank in Chinese -->
                                <input type="text" id="academic_ranks_zh" name="academic_ranks_zh" class="form-control mt-2"
                                    value="{{ old('academic_ranks_zh') }}"
                                    placeholder="{{ App::getLocale() == 'th' ? 'ตำแหน่งทางวิชาการ (ภาษาจีน)' : (App::getLocale() == 'zh' ? '学术头衔 (中文)' : 'Academic Rank (Chinese)') }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 for="department"><b>{{ __('users.department') }} <span class="text-danger">*</span></b></h6>
                                    <select class="form-control" name="department_id" id="department" style="width: 100%;" required>
                                        <option value="">{{ __('users.select_department') }}</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">
                                                @if(app()->getLocale() == 'th')
                                                    {{ $department->department_name_th }}
                                                @elseif(app()->getLocale() == 'zh')
                                                    {{ $department->department_name_zh }}
                                                @else
                                                    {{ $department->department_name_en }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <h6 for="program"><b>{{ __('users.program') }} <span class="text-danger">*</span></b></h6>
                                    <select class="form-control select2" name="program_id" id="program" required>
                                        <option value="">{{ __('users.select_program') }}</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}" data-department="{{ $program->department_id }}">
                                                @if(app()->getLocale() == 'th')
                                                    {{ $program->degree->title_th ?? '' }} ({{ $program->program_name_th }})
                                                @elseif(app()->getLocale() == 'zh')
                                                    {{ $program->degree->title_zh ?? '' }} ({{ $program->program_name_zh }})
                                                @else
                                                    {{ $program->degree->title_en ?? '' }} ({{ $program->program_name_en }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

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
                                    <input type="text" name="bachelor_university_th" class="form-control" value="{{ old('bachelor_university_th') }}" placeholder="{{ __('users.university_name_th') }}">
                                    <input type="text" name="bachelor_university_en" class="form-control" value="{{ old('bachelor_university_en') }}" placeholder="{{ __('users.university_name_en') }}">
                                    <input type="text" name="bachelor_university_cn" class="form-control" value="{{ old('bachelor_university_cn') }}" placeholder="{{ __('users.university_name_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.degree_full') }}</b></label>
                                    <input type="text" name="bachelor_degree_th" class="form-control" value="{{ old('bachelor_degree_th') }}" placeholder="{{ __('users.degree_full_th') }}">
                                    <input type="text" name="bachelor_degree_en" class="form-control" value="{{ old('bachelor_degree_en') }}" placeholder="{{ __('users.degree_full_en') }}">
                                    <input type="text" name="bachelor_degree_cn" class="form-control" value="{{ old('bachelor_degree_cn') }}" placeholder="{{ __('users.degree_full_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.graduation_year') }}</b></label>
                                    <div class="col-full">
                                        <input type="text" id="bachelor_year_th" name="bachelor_year_th" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาตรี' : 'Graduation Year (Thai)' }}"
                                            value="{{ old('bachelor_year_th') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="bachelor_year_en" name="bachelor_year_en" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาตรี' : 'Graduation Year (English)' }}"
                                            value="{{ old('bachelor_year_en') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="bachelor_year_cn" name="bachelor_year_cn" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? '毕业年份' : 'Graduation Year (Chinese)' }}"
                                            value="{{ old('bachelor_year_cn') }}" oninput="updateYears()">
                                    </div>
                                </div>
                            </div>

                            <!-- Master Form -->
                            <div class="tab-pane fade" id="master" role="tabpanel">
                                <div class="form-group">
                                    <label><b>{{ __('users.university_name') }}</b></label>
                                    <input type="text" name="master_university_th" class="form-control" value="{{ old('master_university_th') }}" placeholder="{{ __('users.university_name_th') }}">
                                    <input type="text" name="master_university_en" class="form-control" value="{{ old('master_university_en') }}" placeholder="{{ __('users.university_name_en') }}">
                                    <input type="text" name="master_university_cn" class="form-control" value="{{ old('master_university_cn') }}" placeholder="{{ __('users.university_name_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.degree_full') }}</b></label>
                                    <input type="text" name="master_degree_th" class="form-control" value="{{ old('master_degree_th') }}" placeholder="{{ __('users.degree_full_th') }}">
                                    <input type="text" name="master_degree_en" class="form-control" value="{{ old('master_degree_en') }}" placeholder="{{ __('users.degree_full_en') }}">
                                    <input type="text" name="master_degree_cn" class="form-control" value="{{ old('master_degree_cn') }}" placeholder="{{ __('users.degree_full_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.graduation_year') }}</b></label>
                                    <div class="col-full">
                                        <input type="text" id="master_year_th" name="master_year_th" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาโท' : 'Graduation Year (Thai)' }}"
                                            value="{{ old('master_year_th') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="master_year_en" name="master_year_en" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาโท' : 'Graduation Year (English)' }}"
                                            value="{{ old('master_year_en') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="master_year_cn" name="master_year_cn" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? '毕业年份' : 'Graduation Year (Chinese)' }}"
                                            value="{{ old('master_year_cn') }}" oninput="updateYears()">
                                    </div>
                                </div>
                            </div>

                            <!-- Doctoral Form -->
                            <div class="tab-pane fade" id="doctoral" role="tabpanel">
                                <div class="form-group">
                                    <label><b>{{ __('users.university_name') }}</b></label>
                                    <input type="text" name="doctoral_university_th" class="form-control" value="{{ old('doctoral_university_th') }}" placeholder="{{ __('users.university_name_th') }}">
                                    <input type="text" name="doctoral_university_en" class="form-control" value="{{ old('doctoral_university_en') }}" placeholder="{{ __('users.university_name_en') }}">
                                    <input type="text" name="doctoral_university_cn" class="form-control" value="{{ old('doctoral_university_cn') }}" placeholder="{{ __('users.university_name_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.degree_full') }}</b></label>
                                    <input type="text" name="doctoral_degree_th" class="form-control" value="{{ old('doctoral_degree_th') }}" placeholder="{{ __('users.degree_full_th') }}">
                                    <input type="text" name="doctoral_degree_en" class="form-control" value="{{ old('doctoral_degree_en') }}" placeholder="{{ __('users.degree_full_en') }}">
                                    <input type="text" name="doctoral_degree_cn" class="form-control" value="{{ old('doctoral_degree_cn') }}" placeholder="{{ __('users.degree_full_cn') }}">
                                </div>
                                <div class="form-group">
                                    <label><b>{{ __('users.graduation_year') }}</b></label>
                                    <div class="col-full">
                                        <input type="text" id="doctoral_year_th" name="doctoral_year_th" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาเอก' : 'Graduation Year (Thai)' }}"
                                            value="{{ old('doctoral_year_th') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="doctoral_year_en" name="doctoral_year_en" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? 'ปีที่สำเร็จการศึกษาปริญญาเอก' : 'Graduation Year (English)' }}"
                                            value="{{ old('doctoral_year_en') }}" oninput="updateYears()">
                                    </div>
                                    <div class="col-full">
                                        <input type="text" id="doctoral_year_cn" name="doctoral_year_cn" class="form-control"
                                            placeholder="{{ App::getLocale() == 'th' ? '毕业年份' : 'Graduation Year (Chinese)' }}"
                                            value="{{ old('doctoral_year_cn') }}" oninput="updateYears()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ปุ่ม Submit และ Cancel -->
                        <div>
                            <button type="submit" class="btn btn-primary mt-3 me-2">{{ __('users.submit') }}</button>
                            <a class="btn btn-secondary mt-3" href="{{ route('users.index') }}">{{ __('users.cancel') }}</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->


<script>
$(document).ready(function() {
    // Get browser language
    const userLang = navigator.language || navigator.userLanguage;
    
    let placeholder = 'Select category'; // Default English
    
    // Set placeholder based on language
    if (userLang.includes('th')) {
        placeholder = 'เลือกหมวดหมู่';
    } else if (userLang.includes('zh')) {
        placeholder = '选择类别';
    }
    
    $('.selectpicker').selectpicker({
    noneSelectedText: '{{ __("users.select_category") }}'
    });
});


$('#cat').on('change', function(e) {
    var cat_id = e.target.value;
    var lang = $('html').attr('lang');  // Get language from the <html lang="xx"> tag
    
    console.log('Current language detected:', lang);  // Log language for debugging
    
    $.get('/ajax-get-subcat?cat_id=' + cat_id + '&lang=' + lang, function(data) {
        $('#subcat').empty();
        $('#subcat').append('<option value="">{{ __("users.select_program") }}</option>');
        
        $.each(data, function(index, areaObj) {
            var title, program;
            
            if (lang === 'th' && areaObj.degree.title_th && areaObj.program_name_th) {
                title = areaObj.degree.title_th;
                program = areaObj.program_name_th;
            }
            else if (lang === 'zh' && areaObj.degree.title_zh && areaObj.program_name_zh) {
                title = areaObj.degree.title_zh;
                program = areaObj.program_name_zh;
            }
            else {
                title = areaObj.degree.title_en;
                program = areaObj.program_name_en;
            }
            
            $('#subcat').append('<option value="' + areaObj.id + '">' + title + ' in ' + program + '</option>');
        });
    });
});



</script>

<script>
document.getElementById('department').addEventListener('change', function() {
    const departmentId = this.value;
    const programDropdown = document.getElementById('program');
    
    // Show all options first
    Array.from(programDropdown.options).forEach(option => {
        option.style.display = '';
    });
    
    if (departmentId) {
        // Hide options that don't match the selected department
        Array.from(programDropdown.options).forEach(option => {
            if (option.dataset.department != departmentId && option.value != '') {
                option.style.display = 'none';
            }
        });
    }
    
    // Reset selection
    programDropdown.value = '';
});
</script>

<script>
    // Dictionary mapping for Thai and Chinese translations
    const academicRanksTranslations = {
        'Lecturer': {
            th: 'อาจารย์',
            zh: '讲师'
        },
        'Assistant Professor': {
            th: 'ผู้ช่วยศาสตราจารย์',
            zh: '助理教授'
        },
        'Associate Professor': {
            th: 'รองศาสตราจารย์',
            zh: '副教授'
        },
        'Professor': {
            th: 'ศาสตราจารย์',
            zh: '教授'
        }
    };

    // Function to update the Thai and Chinese fields
    function updateAcademicRanks() {
        const selectedRank = document.getElementById('academic_ranks_en').value;

        // Check if the selected rank is valid and update the inputs
        if (academicRanksTranslations[selectedRank]) {
            document.getElementById('academic_ranks_th').value = academicRanksTranslations[selectedRank].th;
            document.getElementById('academic_ranks_zh').value = academicRanksTranslations[selectedRank].zh;
        } else {
            // Reset the fields if no rank is selected
            document.getElementById('academic_ranks_th').value = '';
            document.getElementById('academic_ranks_zh').value = '';
        }
    }

    // Add event listener to update fields when the selection changes
    document.getElementById('academic_ranks_en').addEventListener('change', updateAcademicRanks);

    // Trigger the function on page load to set initial values
    updateAcademicRanks();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rankEn = document.getElementById('academic_ranks_en');
        const rankTh = document.getElementById('academic_ranks_th');
        const rankZh = document.getElementById('academic_ranks_zh');

        // Map ค่าจาก localization
        const rankMap = {
            'Lecturer': {
                th: '{{ __('academic_ranks.Lecturer', [], 'th') }}',
                zh: '{{ __('academic_ranks.Lecturer', [], 'zh') }}'
            },
            'Assistant Professor': {
                th: '{{ __('academic_ranks.Assistant Professor', [], 'th') }}',
                zh: '{{ __('academic_ranks.Assistant Professor', [], 'zh') }}'
            },
            'Associate Professor': {
                th: '{{ __('academic_ranks.Associate Professor', [], 'th') }}',
                zh: '{{ __('academic_ranks.Associate Professor', [], 'zh') }}'
            },
            'Professor': {
                th: '{{ __('academic_ranks.Professor', [], 'th') }}',
                zh: '{{ __('academic_ranks.Professor', [], 'zh') }}'
            },
            '': { th: '', zh: '' }
        };

        // อัปเดตค่าเมื่อเปลี่ยน academic_ranks_en
        rankEn.addEventListener('change', function () {
            const selectedRank = this.value;
            const mapped = rankMap[selectedRank] || { th: '', zh: '' };
            rankTh.value = mapped.th;
            rankZh.value = mapped.zh;
        });

        // ตั้งค่าเริ่มต้น
        rankEn.dispatchEvent(new Event('change'));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get input elements
        const yearThInput = document.getElementById('bachelor_year_th');
        const yearEnInput = document.getElementById('bachelor_year_en');
        const yearCnInput = document.getElementById('bachelor_year_cn');

        // Function to update years based on the source input
        function updateYears(sourceInput) {
            const yearTh = yearThInput.value.trim();
            const yearEn = yearEnInput.value.trim();
            const yearCn = yearCnInput.value.trim();

            // If source is Thai year
            if (sourceInput === yearThInput && yearTh !== '') {
                const year = parseInt(yearTh);
                if (!isNaN(year)) {
                    yearEnInput.value = year - 543;
                    yearCnInput.value = year - 543;
                }
            }
            // If source is English year
            else if (sourceInput === yearEnInput && yearEn !== '') {
                const year = parseInt(yearEn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearCnInput.value = year;
                }
            }
            // If source is Chinese year
            else if (sourceInput === yearCnInput && yearCn !== '') {
                const year = parseInt(yearCn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearEnInput.value = year;
                }
            }
            // If the source field is cleared, clear all if no other field has value
            else if (yearTh === '' && yearEn === '' && yearCn === '') {
                yearThInput.value = '';
                yearEnInput.value = '';
                yearCnInput.value = '';
            }
        }

        // Add event listeners to all inputs
        [yearThInput, yearEnInput, yearCnInput].forEach(input => {
            input.addEventListener('input', function () {
                updateYears(this); // 'this' refers to the changed input
            });
        });
    });


    // for master year

    document.addEventListener('DOMContentLoaded', function () {
        // Get input elements
        const yearThInput = document.getElementById('master_year_th');
        const yearEnInput = document.getElementById('master_year_en');
        const yearCnInput = document.getElementById('master_year_cn');

        // Function to update years based on the source input
        function updateYears(sourceInput) {
            const yearTh = yearThInput.value.trim();
            const yearEn = yearEnInput.value.trim();
            const yearCn = yearCnInput.value.trim();

            // If source is Thai year
            if (sourceInput === yearThInput && yearTh !== '') {
                const year = parseInt(yearTh);
                if (!isNaN(year)) {
                    yearEnInput.value = year - 543;
                    yearCnInput.value = year - 543;
                }
            }
            // If source is English year
            else if (sourceInput === yearEnInput && yearEn !== '') {
                const year = parseInt(yearEn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearCnInput.value = year;
                }
            }
            // If source is Chinese year
            else if (sourceInput === yearCnInput && yearCn !== '') {
                const year = parseInt(yearCn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearEnInput.value = year;
                }
            }
            // If the source field is cleared, clear all if no other field has value
            else if (yearTh === '' && yearEn === '' && yearCn === '') {
                yearThInput.value = '';
                yearEnInput.value = '';
                yearCnInput.value = '';
            }
        }

        // Add event listeners to all inputs
        [yearThInput, yearEnInput, yearCnInput].forEach(input => {
            input.addEventListener('input', function () {
                updateYears(this); // 'this' refers to the changed input
            });
        });
    });


    // for doctoral year

    document.addEventListener('DOMContentLoaded', function () {
        // Get input elements
        const yearThInput = document.getElementById('doctoral_year_th');
        const yearEnInput = document.getElementById('doctoral_year_en');
        const yearCnInput = document.getElementById('doctoral_year_cn');

        // Function to update years based on the source input
        function updateYears(sourceInput) {
            const yearTh = yearThInput.value.trim();
            const yearEn = yearEnInput.value.trim();
            const yearCn = yearCnInput.value.trim();

            // If source is Thai year
            if (sourceInput === yearThInput && yearTh !== '') {
                const year = parseInt(yearTh);
                if (!isNaN(year)) {
                    yearEnInput.value = year - 543;
                    yearCnInput.value = year - 543;
                }
            }
            // If source is English year
            else if (sourceInput === yearEnInput && yearEn !== '') {
                const year = parseInt(yearEn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearCnInput.value = year;
                }
            }
            // If source is Chinese year
            else if (sourceInput === yearCnInput && yearCn !== '') {
                const year = parseInt(yearCn);
                if (!isNaN(year)) {
                    yearThInput.value = year + 543;
                    yearEnInput.value = year;
                }
            }
            // If the source field is cleared, clear all if no other field has value
            else if (yearTh === '' && yearEn === '' && yearCn === '') {
                yearThInput.value = '';
                yearEnInput.value = '';
                yearCnInput.value = '';
            }
        }

        // Add event listeners to all inputs
        [yearThInput, yearEnInput, yearCnInput].forEach(input => {
            input.addEventListener('input', function () {
                updateYears(this); // 'this' refers to the changed input
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

</style>

@endsection