@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 align="center">{{ __('User profile') }}</h4>
            <div class="card">
                <div class="card-header">{{ __('Registration data') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('E-mail') }}: {{ Auth::user()->email }}
                    <br/><br/>
                    {{ __('Passport scans') }}: {{ empty(Auth::user()->passport) ? __('not loaded') : '' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
