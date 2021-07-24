@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Settings') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <ul class="uk-list uk-list-divider uk-text-left uk-margin-remove">
            <li></li>
            <li><a href="/settings/account" class="uk-link-muted"><span class="uk-margin-small-right"></span>{{ __('Account') }}</a></li>
            <li><a href="/settings/notifications" class="uk-link-muted"><span class="uk-margin-small-right"></span>{{ __('Notifications') }}</a></li>
            <li><a href="/settings/security" class="uk-link-muted"><span class="uk-margin-small-right"></span>{{ __('Security') }}</a></li>
            <li></li>
        </ul>
    </div>
</div>
@endsection
