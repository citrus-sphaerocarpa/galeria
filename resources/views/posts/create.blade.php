@extends('layouts.home')

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('New Post') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">
        <form id="postForm" action="{{  \LaravelLocalization::localizeURL('/p') }}" enctype="multipart/form-data" method="post">
            @csrf
            <!-- Image -->
            <div>
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Preview Image') }}</h3>
                <div id="parentDiv" class="uk-form-custom square-container">
                    <input type="file" accept='image/*' onchange="previewImage(this)" name="image">
                    <div id="removeChild" class="square-child">
                        <span class="uk-position-absolute uk-transform-center" uk-icon="image" style="left: 50%; top: 50%"></span>
                    </div>
                </div>
                <p class="uk-margin-remove uk-text-small">{{ __('Maximum upload file size: 3MB') }}</p>            
                <div>
                    @error('image')
                        <strong>{{ $message }}</strong>
                    @enderror                
                </div>
            </div>

            <!-- Caption -->
            <div class="uk-margin-small-top">
                <h3 class="uk-margin-small-bottom uk-heading-bullet uk-h4">{{ __('Caption') }}</h3>
                <textarea id="caption" class="uk-textarea @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" placeholder="" maxlength="1000"></textarea>
                <div>
                    @error('caption')
                        <span class="uk-form-danger" role="alert">
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
    </div>
    <div class="uk-placeholder"></div>
</div>
@endsection

@section('uk-navbar-bottom')
<div class="navbar-bottom uk-navbar-container uk-animation-slide-bottom uk-navbar-transparent postbar-background" uk-navbar>
    <div class="uk-navbar-center">
        <div class="uk-navbar-center-left">
        </div>
        <div class="uk-navbar-item">
            <div class="uk-text-center">
                <button type="submit" form="postForm" class="uk-button uk-text-bold">{{ __('Post') }}</button>
            </div>
        </div>
        <div class="uk-navbar-center-right">
            <div class="uk-navbar-right">
            </div>
        </div>
    </div>
</div>
@endsection
