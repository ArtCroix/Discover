<p><br/></p>

@forelse ($event->applications as $app)
    @if (stripos($app->type, 'passport') !== false)
        @if ( $app_submits->contains('application_id' , $app->id))
            <div>{{ __('Паспортные данные загружены.') }}</div>
        @else
            <div>{{ __('Паспортные данные не загружены.') }}</div>
        @endif
        <div><a href="{{ url ('/home/event/' . $event->event_name . '/app/' . $app->id . '/' . app()->getLocale()) }}"
                title="{{ json_decode($app->title, true)[app()->getLocale()] }}">{{ json_decode($app->type, true)[app()->getLocale()] }}</a></div>
    @endif
@empty
    <div>{{ __('Форма для загрузки паспортных данных отсутствует.') }}</div>
@endforelse
