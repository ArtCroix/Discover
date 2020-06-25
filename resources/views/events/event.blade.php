@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">

        <application-tabs current_app_id='{!!$application_id ?? 0!!}'
            event_applications='{!!e(json_encode($eventApplications),true)!!}'>
        </application-tabs>
        <div class="col-md-8">

            <div class="tab-content mt-3">
                <div role="tabpanel" class="tab-pane active" id="base">
                    <h4 class="text-center">
                        {{ json_decode($event->title, true)[app()->getLocale()] }}
                    </h4>
                    <p>
                        {{ __('Здесь вы найдете информацию о событии, приглашения для университетов и визовые приглашения, данные о сборах, форму обратной связи, сертификаты участников и т.д.') }}
                    </p>

                    <div class="card">
                        @if (!empty($team))
                        <div class="card-header">{{ __('Состав команды') }}</div>
                        <div class="card-body">
                            {{ __('Название') }}: {{ $team[0]->team_name }}
                            <br />
                            {{ __('Состав') }}:
                            <ol>
                                @foreach ($team as $team_member)
                                <li>{{$team_member->login}} {{$team_member->lastname}} {{$team_member->firstname}}
                                </li>
                                @endforeach
                            </ol>
                        </div>
                        @else
                        <div class="card-header">{{ __('Вы не приписаны ни к одной из команд') }}</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection