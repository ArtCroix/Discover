@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<main class="main container-fluid pt-1 pb-5">
    <div class="main__content mx-auto">
        <application-edit-form application_data_for_user='{!!e(json_encode($applicationDataForUser),true)!!}'
            additional_data_for_form='{!!e(json_encode($additionalDataForForm),true)!!}'
            strategies='{!!e(json_encode($strategies),true)!!}' is_submitted='{!!e(json_encode($is_submitted),true)!!}'
            user_id='{!!e(json_encode($user_id),true)!!}' />
    </div>
</main>
@endsection
@section('footer')
@include('events.footer')
@endsection