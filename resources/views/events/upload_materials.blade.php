@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <h4>Загрузка методических материалов</h4>
        </div>
        <div class="col-md-8">
            <materials-upload event_name='{!!$event_name!!}'
                uploaded_common_materials_json='{!!e(json_encode($common_materials),true)!!}'
                uploaded_ru_materials_json='{!!e(json_encode($ru_materials),true)!!}'
                uploaded_en_materials_json='{!!e(json_encode($en_materials),true)!!}'></materials-upload>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection