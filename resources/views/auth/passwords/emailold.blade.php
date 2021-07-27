@extends('layouts.auth')

@section('content')

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <div class="card-header">{{ __('Send Reset Link To Email ') }}</div>
        </h2>
            <div class="field">
                @if (session('status'))
                <div class="ui success message">
                  <i class="close icon"></i>
                    <div class="header">
                      {{ session('status') }}
                    </div>
                </div>
              @endif
            </div>
        <form class="ui large form" method="POST" action="{{ route('password.email') }}">
            {!! csrf_field() !!}
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="mail icon"></i>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="ui fluid large blue submit button">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
