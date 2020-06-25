@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Список мероприятий
        </div>
    </div>
    <ul>
        @foreach ($events as $event)
        <li><a href="{{route("show_event_info",$event->event_name)}}">{{$event->event_name}}</a><br>
            <a href="{{route("show_event_edit_form",$event->id)}}">Отредактировать мероприятие</a>
            <br>
            <a href="{{route("upload_materials_page",$event->event_name)}}">Добавить материалы</a></li>
        @endforeach
    </ul>

    <a href="{{route("show_event_create_form",$event->id)}}">Создать мероприятие</a></li>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection