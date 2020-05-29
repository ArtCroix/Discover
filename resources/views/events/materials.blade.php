@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <application-tabs current_app_id='{!!$application_id ?? "materials"!!}'
            event_applications='{!!e(json_encode($eventApplications),true)!!}'>
        </application-tabs>
        <div class="col-md-8 mt-4">
            <h4>{{ __('Методические материалы')}}</h4>
        </div>
        <div class="col-md-8">
            @foreach ($materials as $material)
            <p><a download href="{{'/storage/'.$material}}" target="_blank"
                    rel="noopener noreferrer">{{Str::afterLast($material,"/")}}</a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection