<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- <link rel="shortcut icon" href="{{mix('images/favicon.ico') }}"> --}}
</head>

<body>
    <p>{{ __('Здравствуйте, ') }}{{$user->firstname}}!</p>
    <p>{{ __('Благодарим за регистрацию в личном кабинете Discover! Скоро Вы сможете подать заявку на интересующие сборы, а сейчас необходимо подтвердить адрес электронной почты по ссылке ниже :)') }}</p>

    <p><a href="{{$user->verify_url}}"><button>{{ __('Подтвердить e-mail') }}</button></a></p>

    <p>{{ __('Ознакомиться с расписанием можно по ') }}<a href="https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}">{{ __('ссылке') }}</a>.</p>

    <p>{{ __('Если Вы не регистрировались в личном кабинете Discover, просто проигнорируйте данное сообщение или обратитесь к нашей команде по электронной почте.') }}</p>

    <p>{{ __('До встречи на сборах!') }}<br/>
    {{ __('Команда Discover') }}</p>

    <table cellpadding="10">
    <tr>
        <td valign="top">
            <a class="text-white" href="tel:+79299787555" target="_blank">+7 (929) 97-87-555</a>
            <br/>
            <a href="https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}">https://discover.it-edu.com/{{app()->getLocale() == 'ru' ? '' : app()->getLocale()}}</a>
            <br/>
            <a href="https://facebook.com/moscowicpc" class="text-white footer__social-href" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://vk.com/moscowicpc" class="text-white footer__social-href pl-4" target="_blank">
                <i class="fab fa-vk"></i>
            </a>
            <a href="https://www.instagram.com/moscowicpc/" class="text-white footer__social-href pl-4" target="_blank">
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
