<h3>{{ __('Вы успешно зарегистрированы') }}</h3>

<a href="{{$user->verify_url}}"><button>{{ __('Подтвердить e-mail') }}</button></a>
<p>{{$user->email}}</p>
