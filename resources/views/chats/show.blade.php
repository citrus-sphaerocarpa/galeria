@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
<h1 class="uk-margin-remove">
    <a class="uk-link-reset uk-navbar-item uk-link-heading uk-logo" 
        @if(!$friend->deleted_at)
            href="/profile/{{ $friend->username }}"
        @endif>{{ $friend->deleted_at ? 'Unknown User' : $friend->username }}</a>
</h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <private-chat-message
        :user="{{ auth()->user() }}"
        :friend-id="{{ $friend->id }}"
        :friend-profile-image="{{ $friend->deleted_at ? json_encode('/storage/profile/noimage.png') : json_encode($friend->profile->profileImage()) }}"
        :room-number="{{ json_encode($chat_room->uuid) }}"><private-chat-message/>
</div>
@endsection
