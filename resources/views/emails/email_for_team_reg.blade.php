<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- <link rel="shortcut icon" href="{{mix('images/favicon.ico') }}"> --}}
</head>

<body>
    {{ __('Здравствуйте, ') }}{{$user_name}}!
    <br><br>
    {{ __('Благодарим за регистрацию команды ') }}"{{$team_name}}"{{ __(' в личном кабинете Discover! Скоро вы сможете подать заявку на интересующие сборы, а сейчас вам, как члену команды, необходимо подтвердить адрес электронной почты по ссылке ниже :)') }}
    <br><br>
    <a href="{{$add_team_member_url}}">{{ __('нажмите на ссылку') }}</a>
    <br><br>
    {{ __('Ознакомиться с расписанием можно по ') }}<a
        href="https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}">{{ __('ссылке') }}</a>.
    <br><br>
    {{ __('Если вы не регистрировали команду в личном кабинете Discover, просто проигнорируйте данное сообщение или обратитесь к нашей команде по электронной почте.') }}
    <br><br>
    {{ __('Ссылки на оплату') }}

    @if($currency == 'rub')
    @foreach ($user_emails as $email)
    @if ($email)
    <li><a href="{{route("payment_page",[$event_name,$team_id,app()->getLocale(),"email"=>$email])}}">{{$email}}</a>
    </li>
    @endif
    @endforeach
    @else
    @foreach ($user_emails as $email)
    @if ($email)
    <li><a href="{{route("usd_payment_page",[$event_name,$team_id,app()->getLocale(),"email"=>$email])}}">{{$email}}</a>
    </li>
    @endif
    @endforeach
    @endif

    <br><br>
    {{ __('До встречи на сборах!') }}
    <br>
    {{ __('Команда Discover') }}

    <table cellpadding="10">
        <tr>
            <td valign="top">
                <a class="text-white" href="tel:+79299787555" target="_blank">+7 (929) 97-87-555</a>
                <br />
                <a
                    href="https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}">https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}</a>
                <br />
                <a href="https://facebook.com/moscowicpc" class="text-white footer__social-href" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://vk.com/moscowicpc" class="text-white footer__social-href pl-4" target="_blank">
                    <i class="fab fa-vk"></i>
                </a>
                <a href="https://www.instagram.com/moscowicpc/" class="text-white footer__social-href pl-4"
                    target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </td>
            <td>
                <img src="{{ url('/images/common/wswords.png') }}" height="100" hspace="10" />
                <img src="{{ url('/images/common/discover.png') }}" height="100" />
            </td>
        </tr>
    </table>

</body>

</html>