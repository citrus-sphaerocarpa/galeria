@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <!-- Username -->
    <h1 class="uk-margin-remove uk-logo">
        {{ $user->username }}
    </h1>
@endsection

@section('content')
    <div class="uk-container uk-height-viewport">
        <div class="uk-width-2-3@s uk-align-center">
            <div class="uk-grid-collapse uk-margin-bottom" uk-grid>

                <!-- Profile Image -->
                <div class="uk-width-1-4">
                    <img src="{{ $user->profile->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
                </div>
                    
                <div class="uk-width-3-4 uk-padding-small uk-padding-remove-top">
                    <div class="">

                        <!-- Display name -->
                        <h5 class="uk-margin-small-bottom uk-padding-small uk-padding-remove-vertical uk-padding-remove-left uk-text-truncate">{{ $user->profile->display_name ?? $user->username }}</h5>

                        <ul class="uk-iconnav">
                            @if(auth()->user()->id == $user->id)

                                <!-- Following/Followed Users -->
                                <li><a class="uk-link-muted" href="/follow"><i class="fas fa-users"></i></a></li>

                                <!-- Private Chats -->
                                <li><a class="uk-link-muted" href="/chat"><i class="fas fa-inbox"></i></a></li>

                                <!-- Favorite Posts -->
                                <li><a class="uk-link-muted" href="/favorite"><i class="fas fa-heart"></i></a></li>
                            
                                @else
                                
                                <!-- Follow/Unfollow -->
                                <li><follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button></li>

                                <!-- Private Chat -->
                                <li><a class="uk-link-muted" href="/chat/private/{{ $user->username }}"><i class="fas fa-envelope"></i></a></li>
                                
                            @endif

                            <!-- Edit -->
                            @can ('update', $user->profile)
                                <li><a class="uk-link-muted" href="/profile/{{ $user->username }}/edit"><i class="fas fa-pen"></i></a></li>
                            @endcan

                        </ul>
                    </div>

                    <!-- Biography -->
                    <div>
                        <p class="uk-text-small">
                            {{ $user->profile->biography ?? '' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <!-- User's Posts -->
        <infinite-scroll path="profile" data="{{ $user->username }}"></infinite-scroll>
    </div>
@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
