@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4>{{ __('Страница оплаты')}}</h4>
        </div>
        <div class="col-md-8">
            <p>{{ __('Стоимость участия одного человека')}} {{$price}} {{ __('рублей')}}</p>

            {{ __('Участник')}}: {{$email}}
            <br>
            <br>
            <application-payment-form-rub price='{!!$price!!}' phone='{!!$phone!!}' email='{!!$email!!}'
                event_name='{!!$event_name!!}'>
            </application-payment-form-rub>
            <p class="pt-5">{{ __('Если у вас есть какие-то вопросы, пожалуйста, свяжитесь с нами')}} <a
                    href="mailto:workshops@it-edu.com">workshops@it-edu.com</a>.<br/>
                {{ __('Спасибо')}}!
            </p>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection
@section('additional_scripts')
<script async type="text/javascript" src="{{ mix('js/cloud_payment.js') }}"></script>
@endsection
