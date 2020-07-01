@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Информация по анкете
        </div>
        <div class="col-md-12">

            <p>Список ответов на анкету:</p>


        </div>

    </div>
    <answers-table questions_json='{!!e(json_encode($questions),true)!!}'
        application_json='{!!e(json_encode($application),true)!!}' answers_json='{!!e(json_encode($answers),true)!!}'
        submits_json='{!!e(json_encode($submits),true)!!}'>
    </answers-table>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection