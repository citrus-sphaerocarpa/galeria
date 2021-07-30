@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Search') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <div class="uk-width-2-3@s uk-align-center">
        <!-- Search Form -->
        <form class="uk-search uk-search-default uk-width-1-1" action="/search" method="get" id="searchFormLarge">
            @csrf
            <button class="uk-search-icon-flip" uk-search-icon></button>
            <input class="uk-search-input" type="search" name="keywords" value="{{ $search_query->name }}" placeholder="{{ __('Search')}}">
        </form>
        <div class="uk-margin-small-top">
            @error('keywords')
                <span class="uk-form-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror                
        </div>
    </div>

    <infinite-scroll path="searchTag" data="{{ $search_query->id }}"></infinite-scroll>
</div>

@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
