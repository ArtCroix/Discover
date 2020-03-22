<p><br /></p>

<h4 align="center">
	{{ json_decode($event->title, true)[app()->getLocale()] }}
</h4>
<p>
	{{ __('Здесь вы найдете информацию о событии, приглашения для университетов и визовые приглашения, данные о сборах, форму обратной связи, сертификаты участников и т.д.') }}
</p>

<div class="card">
	<div class="card-header">{{ __('Состав команды') }}</div>

	<div class="card-body">
		@if (session('status'))
		<div class="alert alert-success" role="alert">
			{{ session('status') }}
		</div>
		@endif

		{{ __('Название') }}: {{ $event->teams->first()->team_name }}
		<br />
		{{ __('Состав') }}:
		<ol>
			@forelse ($event->teams->first()->pivot->where('team_id', $event->teams->first()->id)->where('event_id',
			$event->id)->get('user_id') as $user_id)
			<li>
				{{ App\User::find($user_id)->first()->firstname }} {{ App\User::find($user_id)->first()->lastname }}
			</li>
			@empty
			<li>
				{{ __('нет данных') }}
			</li>
			@endforelse
		</ol>
	</div>
</div>

<p><br /></p>

<div class="card">
	<div class="card-header">{{ __('Детали платежа') }}</div>

	<div class="card-body">
		{{ __('Стоимость участия') }}:
		@forelse (json_decode($event->price, true) as $currency => $data)
		@if ($currency == (app()->getLocale() == 'en' ? 'usd' : 'rub' ))
		@forelse ($data as $date => $price)
		@if (time() < $date) {{ $price . ' ' . ($currency == 'usd' ? __('USD') : __('rub')) }} @break @endif @empty
			{{ __('нет данных') }} @endforelse @if (time()> $date)
			{{ __('срок оплаты истёк') }}
			@endif
			@endif
			@empty
			<li>
				{{ __('нет данных') }}
			</li>
			@endforelse
	</div>
</div>