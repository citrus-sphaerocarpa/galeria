@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Edit Profile') }}
    </h1>
@endsection

@section('uk-navbar-center-title')
<a class="uk-navbar-item uk-logo" href="/home">galeria</a>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="updateProfileForm" action="{{  LaravelLocalization::LocalizeURL(route('profile.update', ['username' => $user->username])) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')

            <!-- Profile Image -->
            <div class="uk-margin-medium-bottom">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Preview Image') }}</h3>
                <div id="parentDiv" class="uk-form-custom profile-image">
                    <input id="image" type="file" name="image" onchange="previewImage(this)">
                    <img src="{{ $user->profile->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
                </div>
                <p class="uk-margin-remove uk-text-small">{{ __('Maximum upload file size: 3MB') }}</p>    
                @error('image')
                <div class="uk-form-danger">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <!-- Display Name -->
            <div class="uk-margin-small-bottom">
                <h3 class="uk-margin-remove uk-heading-bullet uk-h4">{{ __('Display Name') }}</h3>
                <textarea class="uk-textarea textarea-fix" name="display_name" value="{{ old('display_name') }}" id="displayName" rows="1" maxlength="25">{{ $user->profile->display_name ?? $user->username }}</textarea>
                @error('display_name')
                <div class="uk-form-danger">
                    <strong>{{ $message }}</strong>
                </div>    
                @enderror
            </div>

            <!-- Biography -->
            <div>
                <h3 class="uk-margin-remove uk-heading-bullet uk-h4">{{ __('Biography') }}</h3>
                <textarea class="uk-textarea" name="biography" value="{{ old('biography') }}" id="biography" rows="3" maxlength="200">{{ $user->profile->biography ?? '' }}</textarea>
                @error('biography')
                    <span class="uk-form-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                        
            </div>

        </form>
        <div class="uk-placeholder"></div>
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
                <button type="submit" form="updateProfileForm" class="uk-button uk-text-bold">{{ __('Save') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection