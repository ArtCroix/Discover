@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Пользователи
        </div>
        <div class="col-md-8">
            <ul>
                @foreach ($users as $user)
                <li>
                    <p><a href="{{route("user_info",[$user->id])}}">{{$user->login}}</a></p>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection