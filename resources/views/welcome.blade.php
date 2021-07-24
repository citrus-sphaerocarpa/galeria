@extends('layouts.app')

@section('content')
<div class="uk-width-2-3 uk-width-1-3@s uk-margin-xlarge-top">
    <h1 class="logo uk-heading-medium uk-text-center" style="color: #fff">galeria</h1>             
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <input id="email" type="email" class="uk-input uk-form-blank uk-background-muted @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-mail Address')}}" autofocus>
        
        @error('email')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror

        <input id="password" type="password" class="uk-input uk-form-blank uk-background-muted uk-margin-small-top @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
        @if (Route::has('password.request'))
            <div class="uk-margin-remove">
                <a class="uk-text-small uk-link-muted" href="{{ route('password.request') }}"><span style="color: #666">{{ __('Forgot your password?') }}</span></a>
            </div>
        @endif

        @error('password')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror
        
        <div class="uk-text-center uk-margin">
            <button type="submit" class="uk-button uk-button-primary"><b>{{ __('Log in') }}</b></button>
            <div class="uk-margin-small-top">
                <label style="color: #666"><input class="uk-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="uk-margin-small-left">{{ __('Remember me') }}</span></label>
            </div>
        
            <p class="uk-margin-large uk-margin-remove-bottom">
                <a class="uk-link-muted" href="{{ route('register') }}">{{ __('Create your galeria account') }}</a>
            </p>
        </div>
    </form>
</div>
@endsection
