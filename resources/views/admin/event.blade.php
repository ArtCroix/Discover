@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Информация по мероприятию
        </div>
        <div class="col-md-8">
            <p>Список анкет</p>
            <ul>
                @foreach ($event->applications as $application)
                <li>
                    <span>{{json_decode($application->tab_title)->ru}}</span>
                    /
                    <a href="{{route("show_app_answers",[$application->id])}}">Таблица ответов</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-8">
            <p>Список команд</p>

            @foreach ($event->teams as $team)
            <p class="mb-0 mt-3">{{$team->team_name}} ({{$team->country}} {{$team->city}} {{$team->university}}) <a
                    target="_blank" href="{{route("show_form_for_user",[$team->submit_id])}}">Редактировать</a>
            </p>
            <form action="{{ route('delete_team',$team->id) }}" method="post">
                @csrf
                <input type="hidden" name="event_name" value="{{$event->event_name}}">
                <input type="submit" value="Удалить команду">
            </form>
            <a class="btn btn-primary" data-toggle="collapse" href="#team_user_list_{{$team->id}}" role="button"
                aria-expanded="false" aria-controls="team_user_list_{{$team->id}}">
                Список участников:
            </a>
            <div class="collapse" id="team_user_list_{{$team->id}}">
                <div class="card card-body">
                    <ul>
                        @foreach ($team->users as $user)
                        <li>{{$user->firstname}} {{$user->lastname}}<admin-user-unbind-button
                                team_id_json='{!!e(json_encode($team->id),true)!!}'
                                user_id_json='{!!e(json_encode($user->id),true)!!}'>
                            </admin-user-unbind-button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection