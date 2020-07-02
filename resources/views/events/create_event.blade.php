@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <h5 class="text-center">Форма создания мероприятия</h5>

            <form method="POST" name="create_event" action="{{ route('create_event') }}">
                @csrf
                <div class="form-group row">
                    <label for="event_name" class="col-md-4 col-form-label text-md-right">Название (латинскими буквами
                        без пробелов)<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="event_name" type="event_name" class="form-control" name="event_name" required
                            autocomplete="event_name">
                        <div class="d-block invalid-feedback event_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="full_name_ru" class="col-md-4 col-form-label text-md-right">Полное название на
                        русском<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="full_name_ru" type="full_name_ru" class="form-control" name="full_name_ru" required
                            autocomplete="full_name_ru">
                        <div class="d-block invalid-feedback full_name_ru"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="full_name_en" class="col-md-4 col-form-label text-md-right">Полное название на
                        английском<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="full_name_en" type="full_name_en" class="form-control" name="full_name_en" required
                            autocomplete="full_name_en">
                        <div class="d-block invalid-feedback full_name_en"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" type="description" class="form-control" name="description" required
                        autocomplete="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group row">
                    <label for="dates" class="col-md-4 col-form-label text-md-right">Даты проведения<span
                            class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="dates" type="dates" class="form-control" name="dates" required autocomplete="dates">
                        <div class="d-block invalid-feedback dates"></div>
                    </div>
                </div>
                <set-price-for-event></set-price-for-event>
                {{--      <div class="form-group">
                    <label for="price">Цены</label>
                    <p class="mb-1">Образец заполнения:</p>
                    <code>{"rub":{"full":{"2020-04-20":"50000","2020-04-25":"60000","2020-04-30":"140000"},"partial":{"2020-04-20":"50000","2020-04-25":"60000","2020-04-30":"70000"}},"usd":{"full":{"2020-04-20":"1000","2020-04-25":"1200","2020-04-30":"1400"},"partial":{"2020-04-20":"1000","2020-04-25":"1200","2020-04-30":"1400"}}}</code>
                <textarea name="price" class="form-control" id="price" rows="5"></textarea>
        </div> --}}
        {{-- <event-create-button></event-create-button> --}}
        @php
        $post_action=route('create_event');
        @endphp
        <send-form-data-button form_name='create_event' post_action='{!! $post_action !!}'
            success_message='Мероприятие создано' submit_button_text='Создать мероприятие'>
        </send-form-data-button>
        </form>
    </div>
</div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection