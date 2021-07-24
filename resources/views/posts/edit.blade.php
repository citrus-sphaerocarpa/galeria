@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Edit Post') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="updatePostForm" name="updatePostForm" action="{{  LaravelLocalization::LocalizeURL(route('post.update', ['post' => $post->id])) }}" method="post">
            @csrf
            @method('PATCH')
            <!-- Image(View Only) -->
            <div>
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Image') }}<span class="uk-label uk-margin-small-left"><i class="fas fa-eye"></i> {{ __('View Only') }}</span></h3>
                <div id="parentDiv" class="uk-form-custom">
                    <img src="/storage/{{ $post->image }}" alt="" class="uk-responsive-width">
                </div>                
            </div>

            <!-- Caption -->
            <div class="uk-margin-medium-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Caption') }}</h3>
                <textarea id="caption" class="uk-textarea @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" rows="3" maxlength="1000" autofocus>{{ $post->caption }}</textarea>
                <div>
                    @error('caption')
                        <span class="uk-form-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>      
            </div>

            <!-- Tags -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Tags') }}</h3>
                <input-tags></input-tags>
                <div>
                    @error('tags')
                        <span class="uk-form-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror  
                </div>      
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
                <button type="submit" form="updatePostForm" class="uk-button uk-text-bold">{{ __('Save') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection