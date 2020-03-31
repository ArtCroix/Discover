<p><br /></p>

<h4 align="center">
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
			<li>{{$team_member->login}} {{$team_member->lastname}} {{$team_member->firstname}}</li>
			@endforeach
		</ol>
	</div>
	@else
	<div class="card-header">{{ __('Вы не приписаны ни к одной из команд') }}</div>
	@endif
</div>

<p><br /></p>
