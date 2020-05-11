@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card-body">
                Отредактировать команду
                <form name="team_edit" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="team_name" class="col-md-4 col-form-label text-md-right">Название команды</label>
                        <div class="col-md-6">
                            <input id="team_name" type="text" class="form-control" name="team_name"
                                value="{{ $team->team_name }}" required autofocus>
                            <div class="d-block invalid-feedback team_name"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="team_name" class="col-md-4 col-form-label text-md-right">Страна</label>
                        <div class="col-md-6">
                            <input id="country" type="text" class="form-control" name="country"
                                value="{{ $team->country }}" required autofocus>
                            <div class="d-block invalid-feedback country"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="team_name" class="col-md-4 col-form-label text-md-right">Город</label>
                        <div class="col-md-6">
                            <input id="city" type="text" class="form-control" name="city" value="{{ $team->city }}"
                                required autofocus>
                            <div class="d-block invalid-feedback city"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="team_name" class="col-md-4 col-form-label text-md-right">Университет</label>
                        <div class="col-md-6">
                            <input id="university" type="text" class="form-control" name="university"
                                value="{{ $team->university }}" required autofocus>
                            <div class="d-block invalid-feedback university"></div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <admin-team-edit-button team_id_json='{!!e(json_encode($team->id),true)!!}'>
                        </admin-team-edit-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
@include('events.footer')
@endsection