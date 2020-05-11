@extends('layouts.custom_app')
@section('header')
    @include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Внимание! Ваш аккаунт не подтвержден.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('На ваш e-mail адрес отправлено повторное письмо с подтверждением') }}
                        </div>
                    @endif

                    {{ __('Для начала работы с Личным кабинетом участника мероприятия подтвердите, пожалуйста, ваш e-mail по ссылке из письма, отправленного при регистрации.') }}
                    {{ __('Если вы не получили e-mail, ') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('нажмите на ссылку') }}</button>.
                    </form>
                    {{ __(' для повторной отправки письма.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
