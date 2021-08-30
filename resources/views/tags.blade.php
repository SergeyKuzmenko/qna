@extends('layouts.app')
@section('title', 'Теги')

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1>Теги</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row mb-3 filter-menu">
                    <div class="col-3">
                        <a href="{{ request()->fullUrlWithQuery(['by' => 'followers']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'followers' || request()->input('by') == null) ? 'active' : '' }}">По подписчикам</a>
                    </div>
                    <div class="col-3">
                        <a href="{{ request()->fullUrlWithQuery(['by' => 'questions']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'questions') ? 'active' : '' }}">По вопросам</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach( $tags as $tag)
                    <div class="col-lg-3 col-md-4 col-sm-4 col-sm-6">
                        <x-tag :tag="$tag"></x-tag>
                    </div>
                @endforeach
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="float-lg-right">
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
