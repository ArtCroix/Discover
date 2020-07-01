@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <h5 class="text-center">Форма редактирования мероприятия</h5>

            <form method="POST" name="edit_event" action="{{ route('edit_event',$event->id) }}">
                @csrf
                {{--                  <div class="form-group row">
                    <label for="event_name" class="col-md-4 col-form-label text-md-right">Название (латинскими буквами
                        без пробелов)<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="event_name" type="event_name" class="form-control" name="event_name"
                            value="{{ $event->event_name }}" required autocomplete="event_name">
                <div class="d-block invalid-feedback event_name"></div>
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="full_name_ru" class="col-md-4 col-form-label text-md-right">Полное название на
            русском<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <input id="full_name_ru" type="full_name_ru" class="form-control" name="full_name_ru"
                value="{{ json_decode($event->title)->ru }}" required autocomplete="full_name_ru">
            <div class="d-block invalid-feedback full_name_ru"></div>
        </div>
    </div>
    <div class="form-group row">
        <label for="full_name_en" class="col-md-4 col-form-label text-md-right">Полное название на
            английском<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <input id="full_name_en" type="full_name_en" class="form-control" name="full_name_en"
                value="{{ json_decode($event->title)->en }}" required autocomplete="full_name_en">
            <div class="d-block invalid-feedback full_name_en"></div>
        </div>
    </div>

    <fieldset class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Статус мероприятия</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="active" id="active" value="1"
                        {{($event->active==1)?"checked" : ""}}>
                    <label class="form-check-label" for="active">
                        Активно
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="active" id="inactive" value="0"
                        {{($event->active==0)?"checked" : ""}}>
                    <label class="form-check-label" for="inactive">
                        Не активно
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Доступно только админам</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="admin_only" id="yes" value="1"
                        {{($event->admin_only==1)?"checked" : ""}}>
                    <label class="form-check-label" for="yes">
                        Да
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="admin_only" id="no" value="0"
                        {{($event->admin_only==0)?"checked" : ""}}>
                    <label class="form-check-label" for="no">
                        Нет
                    </label>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="form-group">
        <label for="description">Описание</label>
        <textarea id="description" type="description" class="form-control" name="description" required
            autocomplete="description" class="form-control" rows="3">{{ $event->description }}</textarea>
    </div>
    <div class="form-group row">
        <label for="dates" class="col-md-4 col-form-label text-md-right">Даты проведения<span
                class="text-danger">*</span></label>
        <div class="col-md-6">
            <input id="dates" type="dates" class="form-control" name="dates" value="{{ $event->dates }}" required
                autocomplete="dates">
            <div class="d-block invalid-feedback dates"></div>
        </div>
    </div>
    <set-price-for-event prices_json='{!!$event->price!!}'>></set-price-for-event>
    <event-edit-button event_id='{!!$event->id!!}'></event-edit-button>
    </form>
</div>
</div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection