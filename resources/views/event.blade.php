@extends('layouts.custom_app')
@section('header')
@include('components.nav')
@endsection
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-link active"><a href="#base" aria-controls="base" role="tab"
                            data-toggle="tab">&emsp;{{ __('Начало') }}&emsp;</a></li>
                    <li role="presentation" class="nav-link"><a href="#anketa" aria-controls="anketa" role="tab"
                            data-toggle="tab">&emsp;{{ __('Анкета') }}&emsp;</a></li>
                    <li role="presentation" class="nav-link"><a href="#invite" aria-controls="invite" role="tab"
                            data-toggle="tab">&emsp;{{ __('Приглашение') }}&emsp;</a></li>
                    <li role="presentation" class="nav-link"><a href="#passport" aria-controls="passport" role="tab"
                            data-toggle="tab">&emsp;{{ __('Паспорт') }}&emsp;</a></li>
                    <li role="presentation" class="nav-link disabled"><a href="#data" aria-controls="data" role="tab"
                            data-toggle="tab">&emsp;{{ __('Информация') }}&emsp;</a></li>
                </ul>
                <div class="tab-content mb30">
                    <div role="tabpanel" class="tab-pane active" id="base">@include('events_tabs/base')</div>
                    <div role="tabpanel" class="tab-pane" id="anketa">@include('events_tabs/anketa')</div>
                    <div role="tabpanel" class="tab-pane" id="invite">@include('events_tabs/invite')</div>
                    <div role="tabpanel" class="tab-pane" id="passport">@include('events_tabs/passport')</div>
                    <div role="tabpanel" class="tab-pane" id="data">@include('events_tabs/data')</div>
                </div>
            </div>
            <p><br /></p>

        </div>
    </div>
</div>
@endsection
