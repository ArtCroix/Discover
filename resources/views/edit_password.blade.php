@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Регистрация') }}
                </div>
                <div class="card-body">
                    <p><span class="text-danger">*</span> - {{ __('поля, обязательные к заполнению') }}</p>
                    <form method="POST" name="user_reg" action="{{ route('register') }}">
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
                            <user-edit-password-button></user-edit-password-button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection