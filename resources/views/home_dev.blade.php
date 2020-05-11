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
                                </thead>

                                <tbody>
                                    @forelse ($events->where('active', 1) as $event)
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Перейти к мероприятию') }}">
                                                    {{ json_decode($event->title, true)[app()->getLocale()] }}
                                                </a></div>
                                        </td>
                                        {{--                    <td class="table-text">
                                            @if (!empty($event->teams_auth_user->first()))
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                        title="{{ __('Перейти к мероприятию') }}">
                                        {{ json_decode($event->title, true)[app()->getLocale()] }}
                                        </a>
                        </div>
                        @else
                        {{ json_decode($event->title, true)[app()->getLocale()] }}
                        @endif
                        </td> --}}
                        <td class="table-text">
                            <div>
                                @if (!empty($event->teams_auth_user->first()))
                                {{ $event->teams_auth_user->first()->team_name }}
                                @else
                                @forelse ($event->applications as $app)
                                @if ($app->type == "team_registration")
                                <div><a href="{{ url ('/home/event/' . $event->event_name . '/app/' . $app->id . '/' . app()->getLocale()) }}"
                                        title="{{ json_decode($app->title, true)[app()->getLocale()] }}">{{ __('регистрация команды') }}</a>
                                </div>
                                @endif
                                @empty
                                <div>{{ __('регистрация не началась') }}</div>
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
                                <th>{{ __('Команда') }}</th>
                            </thead>

                            <tbody>
                                @forelse (App\Models\Event::has('teams')->get()->where('active', 0) as $event)
                                <tr>
                                    <td class="table-text">
                                        <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                title="{{ __('Перейти к мероприятию') }}">
                                                {{ json_decode($event->title, true)[app()->getLocale()] }}
                                            </a></div>
                                    </td>
                                    <td class="table-text">
                                        <div>регистрация завершена</div>
                                        {{--  <div>{{ $event->teams_auth_user->first()->team_name }}
                    </div> --}}
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