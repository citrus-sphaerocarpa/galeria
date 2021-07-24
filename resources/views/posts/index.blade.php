@extends('layouts.home')

@section('uk-navbar-left')
    @include('components.bell')  
@endsection

@section('uk-navbar-center-title')
    @include('components.logo')   
@endsection

@section('content')
<div class="uk-container uk-height-viewport">
    @if (session('flash_message'))
        <div uk-alert>
            {{ session('flash_message') }}
        </div>
    @endif
    <infinite-scroll path="p" data="{{ auth()->user()->username }}"></infinite-scroll>
</div>

@endsection

@section('uk-navbar-bottom')
    @include('components.postbar')
@endsection
