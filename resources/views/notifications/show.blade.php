@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Notifications') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">

        <!-- Notification Settings -->
        <form id="changeNotificationsForm" name="change_notifications_form" action="{{  \LaravelLocalization::localizeURL('/settings/notifications') }}" method="POST">
            @csrf
            @method('PATCH')
            <!-- New Followers -->
            <div class="">
                <h4 class="uk-margin-small-bottom">
                    <input class="uk-checkbox" name="new_followers" type="checkbox" value="true" {{ $new_followers == '1' ? 'checked' : '' }}><span class="uk-margin-small-left">{{ __('New Followers') }}</span>
                </h4>
                <p class="uk-text-muted uk-margin-remove">{{ __('We\'ll send you a notification when a new person starts following you.') }}</p>
            </div>

            <hr>

            <!-- New Messages -->
            <div class="">
                <h4 class="uk-margin-small-bottom">
                    <input class="uk-checkbox" name="new_messages" type="checkbox" value="true" {{ $new_messages == '1' ? 'checked' : '' }}><span class="uk-margin-small-left">{{ __('New Messages') }}</span>
                </h4>
                <p class="uk-text-muted uk-margin-remove">{{ __('We\'ll send you a notification when someone send you a new message on galeria.') }}</p>
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
                <button type="submit" form="changeNotificationsForm" class="uk-button uk-text-bold">{{ __('Save') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection
