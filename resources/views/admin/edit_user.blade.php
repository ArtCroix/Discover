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
                    <form method="POST" name="user_edit">
                        @csrf
                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Логин') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login"
                                    value="{{ $user->login }}" required autocomplete="login" autofocus>

                                <div class="d-block invalid-feedback login"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>
                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname"
                                    value="{{ $user->firstname }}" autocomplete="firstname" autofocus>
                                <div class="d-block invalid-feedback firstname"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname"
                                class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>
                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname"
                                    value="{{ $user->lastname }}" autocomplete="lastname" autofocus>

                                <div class="d-block invalid-feedback lastname"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Отчество"
                                class="col-md-4 col-form-label text-md-right">{{ __('Отчество') }}</label>
                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control" name="middlename"
                                    value="{{ $user->middlename }}" autocomplete="middlename" autofocus>

                                <div class="d-block invalid-feedback middlename"></div>
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Роли</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="user" value="user"
                                            {{($user->role==="user")?"checked" : ""}}>
                                        <label class="form-check-label" for="user">
                                            Пользователь
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="manager"
                                            value="manager" {{($user->role==="manager")?"checked" : ""}}>
                                        <label class="form-check-label" for="manager">
                                            Менеджер
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="admin"
                                            value="admin" {{($user->role==="admin")?"checked" : ""}}>
                                        <label class="form-check-label" for="admin">
                                            Администратор
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row mb-0">
                            <admin-user-edit-button user_id_json='{!!e(json_encode($user->id),true)!!}'>
                            </admin-user-edit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection