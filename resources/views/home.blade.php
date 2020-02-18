@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 align="center">{{ __('Personal Area') }}</h4>
            <!-- Список актуальных мероприятий -->
            <div class="card">
                <div class="card-header">{{ __('Open events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __('This list displays the current events and the names of the teams in which you are registered. Select an event name to view participation details or register for a new event...') }}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Event') }}</th>
                                    <th>{{ __('Registration / Team') }}</th>
                                </thead>

                                <tbody>
                                    @forelse ($events->where('active', 1) as $event)
                                    <tr>
                                        <td class="table-text">
                                            @if (!empty($event->teams->first()))
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Go to event page') }}">
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
                                                        title="{{ __('Go to event registration ') }}">{{ $app->type }}</a>
                                                </div>
                                                @empty
                                                <div>{{ __('registration not available') }}</div>
                                                @endforelse
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="table-text" colspan="2">
                                            <div>{{ __('no events') }}</div>
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
                <div class="card-header">{{ __('Completed events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div>
                            {{ __('This list shows the past events and the names of the teams you participated in in reverse chronological order. Select an event name to view participation details...') }}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>{{ __('Event') }}</th>
                                    <th>{{ __('Team') }}</th>
                                </thead>

                                <tbody>
                                    @forelse (App\Event::has('teams')->get()->where('active', 0) as $event)
                                    <tr>
                                        <td class="table-text">
                                            <div><a href="{{ url('/home/event/' . $event->event_name . '/status/' . app()->getLocale()) }}"
                                                    title="{{ __('Go to event page') }}">
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
                                            <div>{{ __('no events') }}</div>
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
