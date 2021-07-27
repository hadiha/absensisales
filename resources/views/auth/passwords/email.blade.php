@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.email') }}" class="form-signin">
    {!! csrf_field() !!}
    {{-- @if (session('status')) --}}
    {{-- <div class="alert alert-success" role="alert"> --}}
        {{ session('status') }}
    {{-- </div> --}}
    {{-- @endif --}}

    <div class="mb-5">
        <span class="text-muted">Silakan masukan email anda <br>untuk mereset password.</span>
    </div>

    <div class="form-label-group my-5">
        <div class="ui left icon input w-100">
            <i class="mail icon"></i>
            <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        </div>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <button class="btn btn-lg btn-primary btn-login" type="submit">{{ __('Send Password Reset Link') }}</button>

    <div class="footer py-3 w-50 text-left">
        @if (Route::has('password.request'))
            <a class="text-muted" href="{{ route('login') }}">
                {{ __('Login to another account?') }}
            </a>
        @endif
    </div>
</form>
@endsection
