@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('experts.add_new_expert') }}</h4>
            <form name="expForm" action="{{ route('experts.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('experts.select_user') }}:</strong>
                            <select name="user_id" class="form-control" style="margin: 10px 0px;" required>
                                <option value="">{{ __('experts.select_user_placeholder') }}</option>
                                @if(Auth::user()->hasRole('admin'))
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->fname_en ?? ($user->fname_th ?? 'Unnamed') }} 
                                            {{ $user->lname_en ?? ($user->lname_th ?? '') }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ Auth::id() }}" selected>
                                        {{ Auth::user()->fname_en ?? (Auth::user()->fname_th ?? 'Unnamed') }} 
                                        {{ Auth::user()->lname_en ?? (Auth::user()->lname_th ?? '') }}
                                    </option>
                                @endif
                            </select>
                            @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="expertFields">
                            <strong>{{ __('experts.name') }}:</strong>
                            <div class="form-group expert-field">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-3">
                                        <small>{{ __('experts.english') }}</small>
                                        <input type="text" name="expert_name[]" class="form-control" placeholder="{{ __('experts.placeholder_name_en') }}" value="{{ old('expert_name.0') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <small>{{ __('experts.thai') }}</small>
                                        <input type="text" name="expert_name_th[]" class="form-control" placeholder="{{ __('experts.placeholder_name_th') }}" value="{{ old('expert_name_th.0') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <small>{{ __('experts.chinese') }}</small>
                                                <input type="text" name="expert_name_zh[]" class="form-control" placeholder="{{ __('experts.placeholder_name_zh') }}" value="{{ old('expert_name_zh.0') }}">
                                            </div>
                                            <div class="col-md-3 button-container">
                                                <button type="button" class="btn btn-success btn-sm add-field"><i class="mdi mdi-plus"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm remove-field"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ __('experts.submit') }}</button>
                        <a href="{{ route('experts.index') }}" class="btn btn-secondary">{{ __('experts.cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const expertFields = document.getElementById('expertFields');
    const btnSave = document.getElementById('btn-save');
    const userSelect = document.querySelector('select[name="user_id"]');
    const isAdmin = {{ Auth::user()->hasRole('admin') ? 'true' : 'false' }};

    function validateForm() {
        const userSelected = userSelect.value !== '';
        const fieldSets = expertFields.querySelectorAll('.expert-field');
        const hasExpertData = Array.from(fieldSets).some(fieldSet => 
            Array.from(fieldSet.querySelectorAll('input[name="expert_name[]"]')).some(input => 
                input.value.trim() !== ''
            )
        );

        btnSave.disabled = !(userSelected && hasExpertData);
    }

    function updateRemoveButtons() {
        const removeButtons = expertFields.querySelectorAll('.remove-field');
        const fieldCount = expertFields.querySelectorAll('.expert-field').length;
        removeButtons.forEach(button => {
            button.style.display = fieldCount > 1 ? 'block' : 'none';
        });
    }

    function addInputListeners(fieldSet) {
        fieldSet.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', validateForm);
        });
    }

    userSelect.addEventListener('select', validateForm);

    expertFields.addEventListener('click', function(e) {
        const addButton = e.target.closest('.add-field');
        const removeButton = e.target.closest('.remove-field');

        if (addButton) {
            const newFieldSet = document.createElement('div');
            newFieldSet.classList.add('form-group', 'expert-field');
            newFieldSet.innerHTML = `
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-3">
                        <small>{{ __('experts.english') }}</small>
                        <input type="text" name="expert_name[]" class="form-control" placeholder="{{ __('experts.placeholder_name_en') }}" required>
                    </div>
                    <div class="col-md-3">
                        <small>{{ __('experts.thai') }}</small>
                        <input type="text" name="expert_name_th[]" class="form-control" placeholder="{{ __('experts.placeholder_name_th') }}">
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-9">
                                <small>{{ __('experts.chinese') }}</small>
                                <input type="text" name="expert_name_zh[]" class="form-control" placeholder="{{ __('experts.placeholder_name_zh') }}">
                            </div>
                            <div class="col-md-3 button-container">
                                <button type="button" class="btn btn-success btn-sm add-field"><i class="mdi mdi-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-sm remove-field"><i class="mdi mdi-close"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            expertFields.appendChild(newFieldSet);
            addInputListeners(newFieldSet);
            updateRemoveButtons();
            validateForm();
        }

        if (removeButton) {
            const fieldSet = removeButton.closest('.expert-field');
            if (expertFields.querySelectorAll('.expert-field').length > 1) {
                fieldSet.remove();
                updateRemoveButtons();
                validateForm();
            }
        }
    });

    addInputListeners(expertFields.querySelector('.expert-field'));
    updateRemoveButtons();
    validateForm();
});
</script>

<style>
.button-container {
    display: flex;
    gap: 8px;
    align-items: flex-end;
    padding-bottom: 8px;
}
</style>
@stop