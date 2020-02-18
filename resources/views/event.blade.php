@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 align="center">
                {{ json_decode($event->title, true)[app()->getLocale()] }}
            </h4>
            <p>
                {{ __('Here you will find information about this event, invitations for universities and visa invitations, data on fees, feedback form, participant certificates, etc.') }}
            </p>

            <div class="card">
                <div class="card-header">{{ __('Team details') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Name') }}: {{ $event->teams->first()->team_name }}
                    <br/>
                    {{ __('Members') }}:
                    <ol>
                        @forelse ($event->teams->first()->pivot->where('team_id', $event->teams->first()->id)->where('event_id', $event->id)->get('user_id') as $user_id)
                            <li>
                                {{ App\User::find($user_id)->first()->name }}
                            </li>
                        @empty
                            <li>
                                {{ __('no data') }}
                            </li>
                        @endforelse
                    </ol>
                </div>
            </div>

            <p><br/></p>

            <div class="card">
                <div class="card-header">{{ __('Payment details') }}</div>

                <div class="card-body">
                    {{ __('Cost of participation') }}:
                    @forelse (json_decode($event->price, true) as $currency => $data)
                        @if ($currency == (app()->getLocale() == 'en' ? 'usd' : 'rub' ))
                            @forelse ($data as $date => $price)
                                @if (time() < $date)
                                    {{ $price . ' ' . ($currency == 'usd' ? __('USD') : __('rub')) }}
                                    @break
                                @endif
                            @empty
                                {{ __('no data') }}
                            @endforelse
                            @if (time() > $date)
                                {{ __('event deadline') }}
                            @endif
                        @endif
                    @empty
                        <li>
                            {{ __('no data') }}
                        </li>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
