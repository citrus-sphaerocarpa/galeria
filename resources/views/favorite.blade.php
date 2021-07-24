@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    <h1 class="uk-margin-remove uk-logo">
        {{ __('Likes') }}
    </h1>
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    <infinite-scroll path="favoriting" data="{{ auth()->user()->username }}"></infinite-scroll>
</div>

@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
