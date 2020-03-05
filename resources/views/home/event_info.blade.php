@extends('layouts.custom_app')

@section('header')
@include('components.nav')
@endsection
@section('main')
<main class="main container-fluid pt-1 pb-5">
    <div class="main__content mx-auto">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        <application-form application_data_for_user='{!!json_encode($applicationDataForUser)!!}'>
        </application-form>
    </div>
</main>
@endsection
