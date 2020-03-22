@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 align="center">{{ __('Профиль пользователя') }}</h4>
            <div class="card">
                <div class="card-header">{{ __('Регистрационные данные') }}</div>
                <p><a href="/edit_profile">Редактировать личные данные</a></p>
                <p><a href="/edit_password">Изменить пароль</a></p>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('E-mail') }}: {{ Auth::user()->email }}
                    <br /><br />
                    {{ __('Сканы паспортов') }}: {{ empty(Auth::user()->passport) ? __('не загружены') : '' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection