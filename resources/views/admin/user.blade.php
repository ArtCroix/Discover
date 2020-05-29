@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Пользователь
        </div>
        <div class="col-md-8">
            {{$user->login}}
            <a href="{{route("show_edit_user_form",$user->id)}}">Редактировать информацию</a>
            <form action="{{ route('delete_user',$user->id) }}" method="post">
                @csrf
                <input type="submit" value="Удалить пользователя">
            </form>
        </div>


    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection