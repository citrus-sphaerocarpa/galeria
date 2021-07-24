@extends('layouts.app')

@section('content')
<div class="uk-width-4-5 uk-width-1-3@s uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center">{{ __('Reset Password') }}</h3>
        <form  uk-margin action="{{ route('password.update') }}" method="POST" >
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <!-- Email -->
            <input id="email" type="email" class="uk-input uk-form-blank uk-background-muted @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="{{ __('E-mail Address') }}" autofocus>
            
            @error('email')
                <div>
                    <span class="uk-form-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror

            <!-- Password -->
            <input id="password" type="password" class="uk-input uk-form-blank uk-background-muted @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('New Password') }}" autofocus>
            
            @error('password')
                <div>
                    <span class="uk-form-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror

            <!-- Copnfimr Password -->
            <input id="password-confirm" type="password" class="uk-input uk-form-blank uk-background-muted" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm New Password') }}" autofocus>

            <div class="uk-text-center uk-margin-medium-top">
                <button type="submit" class="uk-button uk-text-bold">{{ __('Reset Password') }}</button>
            </div>
        </form>
    </div>
    @if (session('status'))
        <div class="uk-alert-primary" uk-alert>
            <p>{{ session('status') }}</p>
        </div>
    @endif
</div>
@endsection
