@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Delete Your Account') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <p class="">
            {{ __("When you delete your account, your profile, photos, comments, likes and followers will be permanently removed.") }}
        </p>
        <form id="deleteAccountForm" action="{{  \LaravelLocalization::localizeURL('/settings/account/delete') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <!-- Current Password -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Current Password') }}</h3>
                <input id="password" type="password" class="uk-input @error('password') is-invalid @enderror"  name="password">
                <div>
                    @error('password')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>   
                <p class="uk-margin-remove uk-text-small uk-text-muted">{{ __('Enter your current password to confirm cancellation of your account.') }}</p>
            </div>

            <div class="uk-text-center uk-margin-medium-top">
                <!-- <button type="button" class="uk-button uk-text-bold" onclick="deleteAccount(this);">{{ __('Permanently Delete My Account') }}</button> -->
                <!-- Delete (an anchor toggiling the modal)-->
                <a class="uk-link-toggle uk-link-muted" href="#deleteAccountModal{{ auth()->user()->id }}" uk-toggle>
                    <button class="uk-button uk-text-bold" type="button">{{ __('Permanently Delete My Account') }}</button>
                </a>
                <!-- The modal -->
                <div id="deleteAccountModal{{ auth()->user()->id }}" uk-modal="container: false;">
                    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical ">
                        <h2 class="uk-modal-title">{{ __('Delete Your Account') }}</h2>
                        <p class="uk-text-default">{{ __('Are you sure you want to delete your account? All of your data and information will be deleted.') }}</p>
                        <p class="uk-text-right">
                            <button class="uk-button uk-button-default uk-text-bold uk-modal-close" type="button">{{ __('Cancel') }}</button>
                            <button class="uk-button uk-button-primary uk-text-bold" type="submit">{{ __('Delete') }}</button>
                        </p>
                    </div>
                </div>
            </div>
            
        </form>
       
    </div>
</div>
@endsection
