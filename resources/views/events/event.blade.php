@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">

        <application-tabs current_app_id='{!!$application_id ?? 0!!}'
            event_applications='{!!e(json_encode($eventApplications),true)!!}'>
        </application-tabs>
        <div class="col-md-8">
            <div>
                <div class="tab-content mb30">
                    <div role="tabpanel" class="tab-pane active" id="base">@include('events.base')</div>
                </div>
            </div>
            <p><br /></p>

        </div>
    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection