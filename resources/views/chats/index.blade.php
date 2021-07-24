@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Chat') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <!-- Chat User List -->
        @if($friends)
            <ul class="uk-link-toggle uk-link-muted uk-list uk-text-left uk-margin-top">
            @foreach($friends as $friend)
                <a href="/chat/private/{{ $friend['username'] }}" class="uk-link-muted">
                    <li>
                        <img src="{{ $friend['deleted_at'] ? '/storage/profile/noimage.png' : $friend['image']}}" alt="" class="uk-border-circle uk-width-1-4 uk-margin-small-right">
                        {{ $friend['deleted_at'] ? 'Unknown User' : $friend['username']}}
                    </li>
                </a>
                <hr>
            @endforeach
            <li></li>
            </ul>
        @else
            <div uk-alert>{{ __('No messages.') }}</div>
        @endif
    </div>
    <div class="uk-placeholder"></div>
</div>
@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
