@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ url('/login') }}" class="form-signin">
    {!! csrf_field() !!}
    <div class="mb-5">
        <span class="text-muted">Silakan Masukkan Username dan Password.</span>
    </div>
    @if (session()->has('message'))
        <div class="ui negative message px-3 py-2">
            <i class="close icon"></i>
            <small>{{ session()->get('message') }}</small>
        </div>
    @endif
    <div class="my-5">
        {{-- <input type="email" id="inputEmail" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Username') }}" value="{{ old('email') }}" required autofocus> --}}
        <div class="ui left icon input w-100">
            <i class="user icon"></i>
            <input id="username" type="username" class="form-control form-control-lg" name="username" value="{{ old('username') }}" placeholder="Username / Email" required autofocus>
        </div>

        {{-- <label for="inputEmail">{{ __('Username') }}</label> --}}

    </div>

    <div class="my-5">
        {{-- <input type="password" id="inputPassword" name="password" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="{{ old('password') }}" required> --}}
        <div class="ui left icon input w-100">
            <i class="lock icon"></i>
            <input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
        </div>

        {{-- <label for="inputPassword">{{ __('Password') }}</label> --}}

    </div>

    <div class="row">
        <div class="col-6">
            <button type="submit" class="ui fluid large blue submit button">Login</button>
            {{-- <button class="btn btn-block btn-orange btn-login" type="submit">{{ __('Login') }}</button> --}}
        </div>
        <div class="col-6">
            <a class="ui fluid large teal submit button" href="{{ url('/register') }}">Register</a>
        </div>
    </div>

    {{-- <div class="footer py-3 w-50 text-left">
        @if (Route::has('password.request'))
            <a class="text-muted" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div> --}}
</form>
@endsection
