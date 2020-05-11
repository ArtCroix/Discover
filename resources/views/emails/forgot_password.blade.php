<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- <link rel="shortcut icon" href="{{mix('images/favicon.ico') }}"> --}}
</head>

<body>
<br><br>
    {{ __('Вы запросили сброс пароля для входа в личный кабинет Discover. Если это были не вы, просто проигнорируйте это сообщение.') }}
    <br><br>
    <a href="{{url(config('app.url').route('password.reset', ['token' => $token, 'email' => $email, 'locale'=>app()->getLocale()], false))}}">{{ __('Сбросить пароль')}}</a>
    <br><br>
    {{ __('Команда Discover') }}

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
