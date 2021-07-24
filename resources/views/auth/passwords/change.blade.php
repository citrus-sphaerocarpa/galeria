@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Password') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="changePasswordForm" name="change_password_form" action="{{  \LaravelLocalization::localizeURL('/settings/security/password') }}" method="POST">
            @csrf

            <!-- Current Password -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Current Password') }}</h3>
                <input id="currentPassword" type="password" class="uk-input @error('current_password') is-invalid @enderror"  name="current_password" required autocomplete="current-password">
                <div>
                    @error('current_password')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>      
            </div>

            <!-- New Password -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('New Password') }}</h3>
                <input id="newPassword" type="password" class="uk-input @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">
                <div>
                    @error('new_password')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>      
            </div>

            <!-- Confirm Password -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Confirm New Password') }}</h3>
                <input id="newPasswordConfirm" type="password" class="uk-input @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" required>
                <div>
                    @error('new_password_confirmation')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>    
            </div>

        </form>

        @if(session()->has('error'))
            <div class="uk-alert-danger" uk-alert>
                <p>{{ session()->get('error') }}</p>
            </div>
        @endif

        @if(session()->has('success'))
            <div class="uk-alert-success" uk-alert>
                <p>{{ session()->get('success') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('uk-navbar-bottom')
<div class="navbar-bottom uk-navbar-container uk-animation-slide-bottom uk-navbar-transparent postbar-background" uk-navbar>
    <div class="uk-navbar-center">
        <div class="uk-navbar-center-left">
        </div>
        <div class="uk-navbar-item">
            <div class="uk-text-center">
                <button type="submit" form="changePasswordForm" class="uk-button uk-text-bold">{{ __('Change Password') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection