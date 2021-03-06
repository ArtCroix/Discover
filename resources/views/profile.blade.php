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
                <div class="card-body">
                    <p><a href="/edit_profile">{{ __('Редактировать личные данные') }}</a></p>
                    <p><a href="/edit_password">{{ __('Изменить пароль') }}</a></p>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p>{{ __('Логин') }}: {{ Auth::user()->login }}</p>
                    <p>{{ __('ФИО') }}: {{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</p>
                    <p>{{ Auth::user()->middlename }}</p>
                    <p>{{ __('E-mail') }}: {{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection