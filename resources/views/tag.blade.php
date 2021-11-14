@extends('layouts.app')
@section('title', 'Информация по тегу «'.$tag->title.'»')

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $tag->title }}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div class="thumb-lg member-thumb mx-auto">
                                    <img class="img-rounded w-100" src="{{ asset($tag->icon) }}" alt="{{ $tag->title }}">
                                </div>
                            </div>

                            <h3 class="profile-username text-center">{{ $tag->title }}</h3>
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $tag->questions_count }}</h5>
                                        <span class="description-text">Вопросов</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $tag->followers_count }}</h5>
                                        <span class="description-text">Подписчиков</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $tag->solution }}%</h5>
                                        <span class="description-text">Решено</span>
                                    </div>
                                </div>
                            </div>
                            @auth()
                                @if(!$tag->is_follow)
                                    <a type="button" href="{{ route('tag.subscribe', ['slug' => $tag->slug]) }}"
                                       class="btn btn-block btn-outline-success btn-sm mt-2">
                                        Подписаться
                                    </a>
                                @else
                                    <a type="button" href="{{ route('tag.unsubscribe', ['slug' => $tag->slug]) }}"
                                       class="btn btn-block btn-outline-danger btn-sm mt-2">
                                        Отписаться
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="info-tab" data-toggle="pill"
                                       href="#info" role="tab"
                                       aria-controls="info" aria-selected="true">Информация</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="questions-tab" data-toggle="pill"
                                       href="#questions" role="tab"
                                       aria-controls="questions" aria-selected="false">Вопросы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="followers-tab" data-toggle="pill"
                                       href="#followers" role="tab"
                                       aria-controls="followers"
                                       aria-selected="false">Подписчики</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="custom-content-above-tabContent">
                                <div class="tab-pane fade mt-2" id="info"
                                     role="tabpanel"
                                     aria-labelledby="info-tab">
                                    {!! $tag->description !!}
                                </div>
                                <div class="tab-pane active" id="questions" role="tabpanel"
                                     aria-labelledby="questions-tab">
                                    <div class="questions mt-2">
                                        @if($tag->questions->count() > 0)
                                            @foreach($tag->questions as $question)
                                                <x-question :question="$question"></x-question>
                                            @endforeach
                                        @else
                                            <h4 class="lead">Еще нет вопросов</h4>
                                        @endif
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <a href="{{ route('tag.questions', ['slug' => $tag->slug]) }}"
                                                   type="button" class="btn btn-block btn-outline-primary">Все
                                                    вопросы по тегу</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="followers" role="tabpanel"
                                     aria-labelledby="followers-tab">
                                    <div class="followers mt-2">
                                        <div class="row">
                                        @if($tag->followers->count() > 0)
                                            @foreach($tag->followers as $user)
                                                <div class="col-lg-4 col-md-6 col-sm-6">
                                                    <div class="text-center card-box {{ (session('dark_mode')) ? 'dark-mode border' : 'border' }}">
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
                                        @else
                                            <h4 class="lead">Еще никто не подписался</h4>
                                        @endif
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <a href="{{ route('tag.followers', ['slug' => $tag->slug]) }}"
                                                   type="button" class="btn btn-block btn-outline-primary">Все
                                                    подписчики тега</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
