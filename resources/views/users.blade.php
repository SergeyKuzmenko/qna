@extends('layouts.app')
@section('title', $title)

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            @if(request()->routeIs('users.all'))
                <div class="col-md-12">
                    <div class="row mb-3 filter-menu">
                        <div class="col-3">
                            <a href="{{ route('users.all') }}" type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == '' || request()->input('by') == null) ? 'active' : '' }}">Новые</a>
                        </div>
                        <div class="col-3">
                            <a href="{{ request()->fullUrlWithQuery(['by' => 'questions']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'questions') ? 'active' : '' }}">По вопросам</a>
                        </div>
                        <div class="col-3">
                            <a href="{{ request()->fullUrlWithQuery(['by' => 'answers']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'answers') ? 'active' : '' }}">По ответам</a>
                        </div>
                        <div class="col-3">
                            <a href="{{ request()->fullUrlWithQuery(['by' => 'rating']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'rating') ? 'active' : '' }}">По рейтингу</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                @foreach( $users as $user)
                    <div class="col-lg-3 col-md-4 col-sm-4 col-sm-6">
                        <div class="text-center card-box {{ (session('dark_mode')) ? 'dark-mode border' : '' }}">
                            <div class="member-card pt-2 pb-2">
                                <div class="thumb-lg member-thumb mx-auto">
                                    <a href="{{ $user->profile->link }}">
                                        <img src="{{ $user->profile->avatar }}" class="rounded-circle img-thumbnail"
                                             alt="{{ $user->profile->full_name }}">
                                    </a>
                                </div>
                                <div class="">
                                    <h4><a href="{{ $user->profile->link }}">{{ $user->profile->full_name }}</a></h4>
                                    <p class="text-muted">
                                        @if($user->profile->short_about)
                                            {{ Str::limit($user->profile->short_about, 20) }}
                                        @else
                                            {{ "@" . $user->profile->username }}
                                        @endif
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <h4>
                                                    <a href="{{ route('user.questions', ['username' => $user->profile->username]) }}">{{ $user->questions_count }}</a>
                                                </h4>
                                                <p class="mb-0 text-muted">Вопросы</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <h4>
                                                    <a href="{{ route('user.answers', ['username' => $user->profile->username]) }}">{{ $user->answers_count }}</a>
                                                </h4>
                                                <p class="mb-0 text-muted">Ответы</p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <h4>{{ $user->profile->rating }}</h4>
                                                <p class="mb-0 text-muted">Рейтинг</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="float-lg-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
