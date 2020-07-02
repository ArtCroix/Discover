@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Изменение пароля') }}
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*</span> - {{ __('поля, обязательные к заполнению') }}</p>
                    <form method="POST" name="edit_password">
                        @csrf
                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Новый пароль') }}&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="new-password">

                                <div class="d-block invalid-feedback password"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Подтверждение пароля') }}&nbsp;<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            {{-- <user-edit-password-button></user-edit-password-button> --}}
                            @php
                            $post_action=route('edit_password',app()->getLocale());
                            @endphp
                            <send-form-data-button form_name='edit_password' post_action='{!! $post_action !!}'
                                success_message='' submit_button_text='Отредактировать данные'>
                            </send-form-data-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection