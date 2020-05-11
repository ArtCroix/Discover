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
        <li><a href="{{route("show_event_info",$event->event_name)}}">{{$event->event_name}}</a></li>
        @endforeach
    </ul>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection