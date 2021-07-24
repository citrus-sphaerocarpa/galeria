@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ $comment ? __('Reply') : __('Comment') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <div class="uk-grid-collapse uk-margin-bottom" uk-grid>

            <!-- Profile Image -->
            <div class="uk-width-1-5">
                <img src="{{ $comment ? $comment->user->profile->profileImage() : $post->user->profile->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
            </div>

            <!-- Username -->
            <div class="uk-width-4-5 uk-padding-small uk-padding-remove-top">
                <ul class="uk-list uk-list-collapse">
                    <li><a class="uk-link-reset uk-text-bold" href="/profile/{{ $comment ? $comment->user->username : $post->user->username }}">{{ $comment ? $comment->user->username : $post->user->username }}</a></li>
                    <li>{{ $comment ? $comment->created_at->format('Y-m-d H:i') : $post->created_at->format('Y-m-d H:i') }}</li>
                </ul>
            </div>
        </div> 
        <p class="uk-text-break new-line">{{ $comment ? $comment->comment : $post->caption }}</p>
    </div>
</div>
@endsection

@section('uk-navbar-bottom')
<div class="uk-flex uk-flex-center navbar-bottom uk-navbar-container uk-animation-slide-bottom uk-navbar-transparent postbar-background" uk-navbar>
    <div class="uk-width-1-2@s uk-padding-small">
        <form 
            @if($comment)
                action="{{  LaravelLocalization::LocalizeURL(route('comment.storeReply', ['post' => $comment->post_id, 'comment' => $comment->id])) }}"
            @else
                action="{{  LaravelLocalization::LocalizeURL(route('comment.store', ['post' => $post->id])) }}"
            @endif
            enctype="multipart/form-data" method="post">   
            @csrf
            <!-- comment -->
            <div class="uk-text-right">
                <textarea id="comment" class="uk-textarea @error('comment') is-invalid @enderror" name="comment" value="{{ old('comment') }}" placeholder=""></textarea>
                <div>
                    @error('comment')
                        <span class="uk-form-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>
                <button class="uk-button uk-button-small uk-text-bold uk-margin-small-top">{{ __('Send') }}</button> 
            </div>
        </form>
    </div>
</div>
@endsection