@extends('layouts.app')

@section('content')
<div class="uk-width-4-5 uk-width-1-3@s uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center">{{ __('Verify Your Email Address') }}</h3>
        <p>
            {{ __('Before proceeding, please check your email for a verification link.') }}
        </p>
        <p>
            {{ __('If you did not receive the email, please request another email.') }}
        </p>
        <div class="uk-text-center">
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="uk-button uk-text-bold">{{ __('Request another email') }}</button>
            </form>
        </div>

    </div>

    @if (session('resent'))
        <div class="uk-alert-success" uk-alert>
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
</div>
@endsection
