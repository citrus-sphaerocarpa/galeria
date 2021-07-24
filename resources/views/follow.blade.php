@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Friends') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <ul class="uk-subnav uk-child-width-expand" uk-switcher uk-tab>
            <li><a href="#">{{ __('Following') }}</a></li>
            <li><a href="#">{{ __('Follower') }}</a></li>
        </ul>

        <ul class="uk-switcher uk-margin">

            <!-- followings -->
            <div class="uk-grid" uk-grid>
                @if($followings)
                    @foreach($followings as $following)
                        <div class="uk-width-1-3">

                            <!-- Profile Image -->
                            <div>
                                <img src="{{ $following->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
                            </div>

                            <div class="uk-flex uk-flex-center">

                                <!-- Username -->
                                <div class="uk-text-truncate uk-margin-small-right">
                                    <a class="uk-link-reset" href="/profile/{{ $following->user->username }}">{{ $following->user->username}}</a>
                                </div>

                                <!-- Follow/Unfollow Button -->
                                <div>
                                    <follow-button user-id="{{ $following->user_id }}" follows="{{ (auth()->user()) ? auth()->user()->following->contains($following->user_id) : false }}"></follow-button>
                                </div>

                            </div> 

                        </div>
                    @endforeach  
                @endif
            </div>

            <!-- followers -->
            <div class="uk-grid" uk-grid>
                @if($followers)
                    @foreach($followers as $follower)
                        <div class="uk-width-1-3">

                            <!-- Profile Image -->
                            <div>
                                <img src="{{ $follower->profile->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
                            </div>

                            <div class="uk-flex uk-flex-center">

                                <!-- Username -->
                                <div class="uk-text-truncate uk-margin-small-right">
                                    <a class="uk-link-reset" href="/profile/{{ $follower->username }}">{{ $follower->username}}</a>
                                </div>

                                <!-- Follow/Unfollow Button -->
                                <div>
                                    <follow-button user-id="{{ $follower->id }}" follows="{{ (auth()->user()) ? auth()->user()->following->contains($follower->id) : false }}"></follow-button>
                                </div>

                            </div>

                        </div>
                    @endforeach 
                @endif
            </div>
        </ul>
        <div class="uk-placeholder"></div>
    </div>
</div>
@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
