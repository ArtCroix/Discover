@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>Страница Администратора.</p>
            <p>Данный раздел предназначен для редактирования мероприятий, состава участников команд, списка
                пользователей, добавления
                методических материалов и аналитики результатов тематических анкет</p>
        </div>
        <div class="col-md-8">
            Перейти к <a href="{{route('show_events')}}">списку мероприятий</a>
        </div>
        <div class="col-md-8">
            Перейти к <a href="{{route('users')}}">списку пользователей</a>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection