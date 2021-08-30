@extends('layouts.app')
@section('title', 'Мои теги')
@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Мои теги ({{ $tags->total() }})</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if($tags->count() > 0 )
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
                                    Вы ещё не подписались ни на один тег
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
