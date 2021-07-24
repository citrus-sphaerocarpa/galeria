@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('All Notifications') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <!-- Notification List -->
        @if($notifications)
            <ul class="uk-link-toggle uk-link-muted uk-list uk-text-left uk-margin-top">
                @foreach($notifications as $notification)
                    @if($notification['type'] == 'App\\Notifications\\NewPrivateMessage')
                        <a href="/chat/private/{{ $notification['username'] }}/?read={{ $notification['id'] }}" class="uk-link-muted">
                            <li>
                                <div class="uk-flex uk-alert-primary" uk-alert>
                                    <div class="uk-width-1-4">
                                        <img src="{{ $notification['image'] }}" alt="" class="uk-border-circle">
                                    </div>
                                    <div class="uk-width-expand uk-margin-small-left">
                                        <p><span class="uk-text-bold">{{ $notification['username'] }}</span>{{ __(' sent you a message.')}}</p>
                                        <p class="uk-text-meta uk-text-italic uk-text-truncate">{{ $notification['data'] }}</p>
                                        <p class="uk-text-small uk-margin-remove">{{ $notification['date'] }}</p>
                                    </div>
                                </div>                         
                            </li>
                        </a>
                    @elseif($notification['type'] == 'App\\Notifications\\NewFollower')
                        <a href="/profile/{{ $notification['username'] }}/?read={{ $notification['id'] }}" class="uk-link-muted">
                            <li>
                                <div class="uk-flex uk-alert-primary" uk-alert>
                                    <div class="uk-width-1-4">
                                        <img src="{{ $notification['image'] }}" alt="" class="uk-border-circle">
                                    </div>
                                    <div class="uk-width-expand uk-margin-small-left">
                                        <p><span class="uk-text-bold">{{ $notification['username'] }}</span>{{ __(' followed you.')}}</p>
                                        <p class="uk-text-small">{{ $notification['date'] }}</p>
                                    </div>  
                                </div>                          
                            </li>
                        </a>
                    @endif
                @endforeach
            </ul>
        @else
            <div uk-alert>{{ __('No notifications.')}}</div>
        @endif
        <div class="uk-placeholder"></div>
    </div>
</div>
@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
