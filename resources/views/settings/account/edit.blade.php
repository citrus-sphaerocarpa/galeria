@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Personal Information') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="editAccountForm" name="edit_account_form" action="{{  \LaravelLocalization::localizeURL('/settings/account/edit') }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Email Address -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('E-mail Address') }}</h3>
                <input id="email" type="email" class="uk-input @error('email') is-invalid @enderror"  name="email" value="{{ $user->email ?? '' }}" autocomplete="email" required>
                <div>
                    @error('email')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>      
            </div>

            <!-- Username -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Username') }}</h3>
                <input id="username" type="username" class="uk-input @error('username') is-invalid @enderror" name="username" value="{{ $user->username ?? '' }}" autocomplete="username" required>
                <div>
                    @error('username')
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
                <button type="submit" form="editAccountForm" class="uk-button uk-text-bold">{{ __('Save') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection