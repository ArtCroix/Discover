@extends('layouts.custom_app')
@section('header')
@include('./components/nav')
@endsection
@section('main')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            Информация по анкете
        </div>
        <div class="col-md-8">
            <p>Пользователи</p>
            <ul>
                @foreach ($application->submits as $submit)
                    @foreach ($submit->users as $user)
                    <li>
                        <p><a href="{{route("user_info",[$user->id])}}">{{$user->login}}</a></p>
                        <p><a href="{{route("show_form_for_user",[$event_name,$application->id,$user->id])}}">Отредактировать анкету</a></p>
                    </li>
                    @endforeach
                @endforeach
            </ul>

            <p>&nbsp;</p>
            <p>Список ответов на анкету:</p>

            <table border="1" cellpadding="10" valign="top">
                <tr>
                    <th>Вопрос</th>
                    @foreach ($application->submits as $submit)
                        @foreach ($submit->users as $user)
                            <th>{{$user->login}}</th>
                        @endforeach
                    @endforeach
                </tr>

                @foreach ($application->questions as $question)
                    @if ($question->id != 223 && $question->id != 225 && $question->id != 227)
                        <tr>
                            <td>{{$question->label}}</td>
                            @foreach ($application->submits as $submit)
                                @foreach ($submit->users as $user)
                                    @foreach ($application->answers as $answer)
                                        @if ($submit->id == $answer->submit_id && $question->id == $answer->question_id)
                                            <td>{{$answer->value}}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>
                    @endif
                @endforeach
            </table>
            <p>&nbsp;</p>
            
        </div>

    </div>
</div>
@endsection
@section('footer')
@include('events.footer')
@endsection
