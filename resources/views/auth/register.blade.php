@extends('layouts.app')

@section('content')
<div class="uk-width-2-3 uk-width-1-3@s uk-margin-large-top">
    <h1 class="logo uk-heading-medium uk-text-center" style="color: #fff">galeria</h1>
    <form uk-margin method="POST" action="{{ route('register') }}">
        @csrf
        <input id="name" type="text" class="uk-input uk-form-blank uk-background-muted @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('Name')}}" autofocus>

        @error('name')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror

        <input id="email" type="email" class="uk-input uk-form-blank uk-background-muted @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-mail Address')}}" autofocus>

        @error('email')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror

        <input id="username" type="text" class="uk-input uk-form-blank uk-background-muted @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="{{ __('Username')}}" maxlength="25" autofocus>

        @error('username')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror

        <input id="password" type="password" class="uk-input uk-form-blank uk-background-muted @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

        @error('password')
        <div>
            <span class="uk-form-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror

        <input id="password-confirm" type="password" class="form-control uk-input uk-form-blank uk-background-muted " name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
        
        <div class="uk-text-center uk-margin-medium">
            <button type="submit" class="uk-button uk-button-primary uk-text-bold">{{ __('Sign up') }}</button>
        </div>
        <p class="uk-text-center uk-text-small">
            {{ __('By signing up, you agree to our Terms, Data Policy and Cookies Policy.') }}       
        </p>

        <p class="uk-margin-large uk-text-center">
            <a class="uk-link-muted" href="{{ route('login') }}">{{ __('Log in') }}</a>
        </p>
    </form>
</div>
@endsection


