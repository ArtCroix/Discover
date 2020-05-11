@php
$to_en = route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' =>
'en'], request()->all())) ;
$to_ru = route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => 'ru'],
request()->all()));
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link"
                    href="{{ url('http://discover.it-edu.com/' . (app()->getLocale() == 'ru' ? '' : app()->getLocale())) }}"
                    title="{{ __('Перейти на сайт') }}">
                    {{ __('Сайт') }}
                </a>
                &emsp;
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home/' . app()->getLocale()) }}"
                    title="{{ __('Перейти к начальной странице') }}">
                    {{ __('Главная') }}
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login',app()->getLocale()) }}">{{ __('Вход') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register',app()->getLocale()) }}">{{ __('Регистрация') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->login }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->role==='admin')
                    <a class="dropdown-item" href="{{ url('/admin/' . app()->getLocale()) }}">
                        {{ __('Админка') }}
                    </a>
                    @endif
                    <a class="dropdown-item" href="{{ url('/profile/' . app()->getLocale()) }}">
                        {{ __('Профиль') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Выход') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
        <div class="navbar__login-button align-items-center col-6 col-sm-2">
            <a class="nav-link dropdown-toggle px-0 " href="" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span v-if="locales.ru">
                    {{-- <img class="w-25" src="{{asset('images/icons/russian.svg')}}" alt=""> --}}
                    Русский
                </span>
                <span v-if="locales.en">
                    {{-- <img class="w-25" src="{{asset('images/icons/english.svg')}}" alt=""> --}}
                    English
                </span>
            </a>
            <div class="dropdown-menu justify-content-center  row no-gutters" aria-labelledby="navbarDropdownLanguage">
                <div class="col-8 mx-auto">
                    <a class="px-0 d-flex justify-content-between align-items-center" v-if="!locales.ru"
                        href="{{$to_ru}}">
                        <span class="mx-auto">Русский</span>
                    </a>
                </div>
                <div class="col-8 mx-auto">
                    <a class="px-0 d-flex justify-content-between align-items-center" v-if="!locales.en"
                        href="{{$to_en}}">
                        <span class="mx-auto">English</span>
                    </a>
                </div>
                {{--     <div class="col-8 mx-auto">
                    <a class="px-0 d-flex justify-content-between align-items-center" v-if="!locales.ru"
                        href="{{ route(\Request::route()->getName(), array_merge(Request::route()->parameters(), ['locale' => 'ru'])) }}">
                <span class="mx-auto">Русский</span>
                </a>
            </div>
            <div class="col-8 mx-auto">
                <a class="px-0 d-flex justify-content-between align-items-center" v-if="!locales.en"
                    href="{{ route(\Request::route()->getName(), array_merge(Request::route()->parameters(), ['locale' => 'en'])) }}">
                    <span class="mx-auto">English</span>
                </a>
            </div> --}}
        </div>
    </div>
    </div>
</nav>