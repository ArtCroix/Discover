@extends('layouts.custom_app')
@section('header')
    @include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтвердите ваш e-mail адрес') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('На ваш e-mail адрес отправлено повторное письмо с подтверждением') }}
                        </div>
                    @endif

                    {{ __('Перед продолжением работы подтвердите ваш e-mail по ссылке из письма') }}
                    {{ __('Если вы не получили e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('кликните для повторной отправки письма') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
