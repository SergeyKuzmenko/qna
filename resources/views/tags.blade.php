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
            <div class="row mb-3 filter-menu">
                <div class="col-md-6 col-sm-12 mt-2">
                    <a href="{{ request()->fullUrlWithQuery(['by' => 'followers']) }} " type="button"
                       class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'followers' || request()->input('by') == null) ? 'active' : '' }}">По
                        подписчикам</a>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <a href="{{ request()->fullUrlWithQuery(['by' => 'questions']) }} " type="button"
                       class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'questions') ? 'active' : '' }}">По
                        вопросам</a>
                </div>
            </div>
            <div class="row">
                @if(count($tags) > 0)
                    @foreach( $tags as $tag)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-sm-6">
                            <x-tag :tag="$tag"></x-tag>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="lead mt-2">
                                    Ничего не найдено
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif
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
