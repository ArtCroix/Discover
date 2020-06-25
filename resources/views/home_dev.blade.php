@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center">{{ __('Личный кабинет') }}</h4>
            <!-- Список актуальных мероприятий -->
            <div class="card">
                <div class="card-header">{{ __('Список мероприятий') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __("В данном разделе отображается список мероприятий, доступных для регистрации с общей информацией по датам проведения.") }}
                            <br />
                            {{ __("Вы можете пройти регистрацию Вашей команды на выбранные мероприятия, а также увидеть, в каких командах вы зарегистрированы.") }}
                            <br />
                            {{ __("Выберите название мероприятия для просмотра сведений об участии или зарегистрируйтесь на новое мероприятие.") }}
                            <br />
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Мероприятие') }}</th>
                                    <th>{{ __('Команда / Регистрация') }}</th>
                                    <th>{{ __('Описание') }}</th>
                                    <th>{{ __('Даты проведения') }}</th>
                                </thead>

                                <tbody>
                                    @forelse ($events->where('active', 1) as $event)
                                    @if ($event->admin_only==1)
                                    @if (Auth::user()->role=="admin")
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                        </td>

                                        <td class="table-text">
                                            <div>
                                                @if (!$event->user_team->isEmpty())
                                                {{ $event->user_team->first()->team_name }}

                                                @else
                                                @forelse ($event->applications as $app)
                                                @if ($app->type == "thematic")
                                                <div><a href="{{ url ('/home/event/' . $event->event_name . '/app/' . $app->id . '/' . app()->getLocale()) }}"
                                                        title="{{ json_decode($app->title, true)[app()->getLocale()] }}">{{ __('регистрация') }}</a>
                                                </div>
                                                @endif
                                                @empty
                                                <div>{{ __('регистрация не началась') }}</div>
                                                @endforelse
                                                @endif

                                            </div>

                                        </td>
                                    </tr>
                                    @endif
                                    @else
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                        </td>

                                        <td class="table-text">
                                            <div>
                                                @if (!$event->user_team->isEmpty())
                                                {{ $event->user_team->first()->team_name }}

                                                @else
                                                @forelse ($event->applications as $app)
                                                @if ($app->type == "thematic")
                                                <div><a href="{{ url ('/home/event/' . $event->event_name . '/app/' . $app->id . '/' . app()->getLocale()) }}"
                                                        title="{{ json_decode($app->title, true)[app()->getLocale()] }}">{{ __('регистрация') }}</a>
                                                </div>
                                                @endif
                                                @empty
                                                <div>{{ __('регистрация не началась') }}</div>
                                                @endforelse
                                                @endif

                                            </div>

                                        </td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td class="table-text" colspan="2">
                                            <div>{{ __('мероприятий не найдено') }}</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <p><br /></p>

            <!-- Список прошедших мероприятий -->
            <div class="card">
                <div class="card-header">{{ __('Прошедшие мероприятия') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __('В данном разделе в обратном хронологическом порядке отображаются прошедшие мероприятия и названия команд, в составе которых вы участвовали.') }}
                            <br />
                            {{ __('Вы можете выбрать мероприятие для просмотра информации о нем.') }}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Мероприятие') }}</th>
                                    <th>{{ __('Регистрация') }}</th>
                                </thead>

                                <tbody>
                                    @forelse ($events->where('active', 0) as $event)
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                        </td>
                                        <td class="table-text">
                                            <div>регистрация завершена</div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="table-text" colspan="2">
                                            <div>{{ __('мероприятий не найдено') }}</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p><br /></p>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection