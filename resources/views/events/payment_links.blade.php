@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <application-tabs current_app_id='{!!$application_id ?? "payment_links"!!}'
            event_applications='{!!e(json_encode($eventApplications),true)!!}'>
        </application-tabs>
        <div class="col-md-8 mt-4">
            <h4>{{ __('Ссылки на оплату')}}</h4>
        </div>
        <div class="col-md-8">
            @if($currency == 'rub')
            @foreach ($user_emails as $email)
            @if ($email)
            <li><a
                    href="{{route("payment_page",[$event_name,$team_id,app()->getLocale(),"email"=>$email])}}">{{$email}}</a>
            </li>
            @endif
            @endforeach
            @else
            @foreach ($user_emails as $email)
            @if ($email)
            <li><a
                    href="{{route("usd_payment_page",[$event_name,$team_id,app()->getLocale(),"email"=>$email])}}">{{$email}}</a>
            </li>
            @endif
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection