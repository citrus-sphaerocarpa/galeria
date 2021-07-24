@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Account') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <ul class="uk-list uk-list-divider uk-text-left uk-margin-remove">
            <li></li>
            <li><a href="/settings/account/edit" class="uk-link-muted"><span class="uk-margin-small-right"></span>{{ __('Personal Information') }}</a></li>
            <li><a href="/settings/account/delete" class="uk-link-muted"><span class="uk-margin-small-right"></span>{{ __('Delete Your Account') }}</a></li>
            <li></li>
        </ul>
    </div>
</div>
@endsection
