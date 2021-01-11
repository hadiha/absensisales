@extends('layouts.auth')

@section('content')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            {{-- <img src="{{ asset('img/grosir-logo.png') }}" class="image" style="width:16em"> --}}
            <div class="content">
                {{ config('app.name') }}
            </div>
        </h2>

        @if (session()->has('message'))
        <div class="ui negative message">
            <i class="close icon"></i>
            <div class="header">
                <strong>Mohon Maaf, </strong>Terjadi Kesalahan<br>
            </div>
            {{ session()->get('message') }}
        </div>
        @endif
        <form class="ui large form" role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username / Email" required autofocus>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>
                <button type="submit" class="ui fluid large blue submit button">Login</button>
                {{-- <a href="{{ url('/register') }}">Register</a> --}}
            </div>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </form>
    </div>
</div>
@endsection
