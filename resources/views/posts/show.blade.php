@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    @include('components.logo')
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-1-2@s uk-align-center uk-padding-small">

        <!-- User's Profile -->
        <div class="uk-grid-collapse uk-margin-small-bottom uk-position-relative" uk-grid>

            <!-- Profile Image -->
            <div class="uk-width-1-5">
                <img src="{{ $post->user->profile->profileImage() }}" alt="" class="uk-border-circle uk-responsive-width">
            </div>
            
            <!-- Username -->
            <div class="uk-width-4-5 uk-padding-small uk-padding-remove-top">
                <ul class="uk-list uk-list-collapse">
                    <li><a class="uk-link-reset uk-text-bold" href="/profile/{{ $post->user->username }}">{{ $post->user->username }}</a></li>
                    <!-- <li>{{ $post->created_at->format('Y-m-d H:i') }}</li> -->
                    <format-date date="{{ $post->created_at }}"></format-date>
                </ul>
            </div>

            <div class="uk-position-bottom-right">
                <!-- More icon -->
                @if(Auth::user()->id == $post->user_id)
                
                <a class="uk-link-reset" href="#" uk-icon="icon: more"></a>
                <div id="dropNav" uk-dropdown="pos: bottom-right; mode: click">
                    <ul class="uk-nav uk-dropdown-nav">
                        <form id="{{ 'deletePost' .  $post->id }}" action="{{  LaravelLocalization::LocalizeURL(route('post.destroy', ['post' => $post->id])) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <!-- Edit -->
                            <li><a class="uk-link-muted uk-margin-bottom" href="/p/{{ $post->id }}/edit">{{ __('Edit') }}</a></li>

                            <!-- Delete (an anchor toggiling the modal)-->
                            <li><a href="#deletePostModal{{ $post->id }}" class="uk-link-muted" uk-toggle>{{ __('Delete') }}</a></li>
                            <!-- The modal -->
                            <div id="deletePostModal{{ $post->id }}" uk-modal="container: false;">
                                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical ">
                                    <p class="uk-text-default">{{ __('Do you really want to delete the seleceted post? This process cannot be undone.') }}</p>
                                    <p class="uk-text-right">
                                        <button class="uk-button uk-button-default uk-text-bold uk-modal-close" type="button">{{ __('No') }}</button>
                                        <button class="uk-button uk-button-primary uk-text-bold" type="submit">{{ __('Yes') }}</button>
                                    </p>
                                </div>
                            </div>

                        </form>
                    </ul>
                </div>
                @endif
            </div>
        </div> 

        <!-- Post -->
        <div>
            <!-- Image -->
            <img class="uk-align-center uk-margin-remove" src="/storage/{{ $post->image }}" alt="">
            <!-- Caption -->
            <p　class="new-line">{{ $post->caption }}</p>
            <!-- Tags -->
            <div class="uk-margin uk-flex uk-flex-wrap">
            @if($tags)
                @foreach($tags as $tag)
                <form id="{{ 'searchTag' .  $tag->id }}" action="/search/tag" method="get">
                    @csrf
                    <div uk-form-custom>
                        <input hidden type="search" name="keyword" value="{{ $tag->name }}">
                        <button class="uk-button uk-button-link uk-margin-small-right">{{ $tag->name }}</button>
                    </div>
                </form>
                @endforeach
            @endif
            </div>
        </div>

        <!-- Comments -->
        <div class="uk-margin-bottom">
            <ul class="uk-iconnav uk-flex uk-flex-right">
                    <favorite-button post-id="{{ $post->id }}" favorites="{{ $favorites }}"></favorite-button>
                    <li><a class="uk-link-muted" href="/p/{{ $post->id }}/comment/create"><i class="fas fa-comment fa-lg"></i></a></li>
            </ul>
        </div>

        <ul class="uk-comment-list uk-margin-remove">
        @include('components.thread', ['comments' => $post->comments, 'post_id' => $post->id])
        </ul>
        <div class="uk-placeholder"></div>
    </div>
</div>

@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
