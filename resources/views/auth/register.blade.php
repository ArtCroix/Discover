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
                            <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Логин') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>
                                {{--   @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                                <div class="d-block invalid-feedback login"></div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Адрес e-mail') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                <div class="d-block invalid-feedback email"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                <div class="d-block invalid-feedback password"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Подтверждение пароля') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname"
                                class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>
                            <div class="col-md-6">
                                <input id="lastname" type="text"
                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    lastname="{{ old('lastname') }}" autocomplete="lastname" autofocus>

                                <div class="d-block invalid-feedback lastname"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>
                            <div class="col-md-6">
                                <input id="firstname" type="text"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                    firstname="{{ old('firstname') }}" autocomplete="firstname" autofocus>

                                <div class="d-block invalid-feedback firstname"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Отчество"
                                class="col-md-4 col-form-label text-md-right">{{ __('Отчество') }}</label>
                            <div class="col-md-6">
                                <input id="middlename" type="text"
                                    class="form-control @error('middlename') is-invalid @enderror" name="middlename"
                                    name="{{ old('middlename') }}" autocomplete="middlename" autofocus>

                                <div class="d-block invalid-feedback middlename"></div>
                            </div>
                        </div>
                        <div class="form-group form-check text-center">
                            <input type="checkbox" value="1" name="agreement"
                                class="form-check-input @error('agreement') is-invalid @enderror" id="agreement">
                            <label class="form-check-label"
                                   for="agreement"><a href="{{ url('/docs/agreement_' . app()->getLocale() . '.docx') }}">
                                    {{ __('Согласие на обработку персональных данных') }}</a><span
                                    class="text-danger">*</span></label>

                            <div class="d-block invalid-feedback agreement"></div>
                        </div>
                        <div class="form-group row mb-0">
                            <user-reg-button></user-reg-button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
