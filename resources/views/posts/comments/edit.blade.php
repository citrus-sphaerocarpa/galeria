@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Edit Comment') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="updateComment" action="{{  LaravelLocalization::LocalizeURL(route('comment.update', ['post' => $comment->post_id, 'comment' => $comment->id])) }}" method="post">
            @csrf
            @method('PATCH')
            <!-- Comment/Reply -->
            <div class="">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Comment') }}</h3>
                    <textarea id="comment" class="uk-textarea @error('comment') is-invalid @enderror" rows="7" name="comment" value="{{ old('comment') }}" autofocus>{{ $comment->comment }}</textarea>
                    <div>
                        @error('comment')
                            <span class="uk-form-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror  
                    </div>      
            </div>
        </form>
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
                <button type="submit" form="updateComment" class="uk-button uk-text-bold">{{ __('Save') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection