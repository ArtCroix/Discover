@extends('layouts.custom_app')
@section('header')
    @include('./components/nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 align="center">{{ __('Личный кабинет') }}</h4>
            <!-- Список актуальных мероприятий -->
            <div class="card">
                <div class="card-header">{{ __('Открытые мероприятия') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __("В этом списке отображаются текущие мероприятия и названия команд, в которых вы зарегистрированы. Выберите название мероприятия для просмотра сведений об участии или зарегистрируйтесь на новое мероприятие...") }}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Мероприятие') }}</th>
                                    <th>{{ __('Регистрация / Команда') }}</th>
                                </thead>

                                <tbody>
                                    @forelse ($events->where('active', 1) as $event)
                                    <tr>
                                        <td class="table-text">
                                            @if (!empty($event->teams->first()))
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                            @else
                                            {{ json_decode($event->title, true)[app()->getLocale()] }}
                                            @endif
                                        </td>
                                        <td class="table-text">
                                            <div>
                                                @if (!empty($event->teams->first()))
                                                "{{ $event->teams->first()->team_name }}"
                                                @else
                                                @forelse ($event->applications as $app)
                                                <div><a href="{{ url ('/home/event/' . $event->event_name . '/app/' . $app->id . '/' . app()->getLocale()) }}"
                                                        title="{{ __('Зарегистрироваться на мероприятие') }}">{{ $app->type }}</a>
                                                </div>
                                                @empty
                                                <div>{{ __('регистрация недоступна') }}</div>
                                                @endforelse
                                                @endif
                                            </div>
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

            <p><br /></p>

            <!-- Список прошедших мероприятий -->
            <div class="card">
                <div class="card-header">{{ __('Завершённые мероприятия') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __('В этом списке в обратном хронологическом порядке отображаются прошедщие мероприятия и названия команд, в составе которых вы участвовали. Выберите название мероприятия для просмотра сведений об участии...') }}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Мероприятие') }}</th>
                                    <th>{{ __('Команда') }}</th>
                                </thead>

                                <tbody>
                                    @forelse (App\Event::has('teams')->get()->where('active', 0) as $event)
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $event->teams->first()->team_name }}</div>
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
</div>
@endsection
