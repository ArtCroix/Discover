@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Информация по анкете
        </div>
        <div class="col-md-8">

            <p>Список ответов на анкету:</p>

            <table border="1" cellpadding="10" valign="top">

            </table>


        </div>

    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection