@extends('layouts.app')

@section('content')
<div class="uk-width-4-5 uk-width-1-3@s uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center">{{ __('Reset Your Password') }}</h3>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <p>
                {{ __('Enter the email address that you used to register.') }}
                {{ __('We’ll send you an email with a link to reset your password.') }} 
            </p>
            <input id="email" type="email" class="uk-input uk-form-blank uk-background-muted @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-mail Address') }}" autofocus>

            @error('email')
            <div>
                <span class="uk-form-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            </div>
            @enderror

            <div class="uk-text-center uk-margin-medium-top">
                <button type="submit" class="uk-button uk-text-bold">{{ __('Send') }}</button>
            </div>
        </form>
    </div>
    @if (session('status'))
        <div class="uk-alert-success" uk-alert>
            <p>{{ session('status') }}</p>
        </div>
    @endif
</div>
@endsection
