@extends('layouts.app')
@section('title', $user->profile->full_name)

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $user->profile->full_name }}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ $user->profile->avatar }}" alt="">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->profile->full_name }}</h3>

                            @if($user->profile->short_about)
                                <p class="text-muted text-center">{{ $user->profile->short_about }}</p>
                            @else
                                <p class="text-muted text-center">{{ '@'. $user->profile->username }}</p>
                            @endif

                            <ul class="list-group list-group-unbordered mb-1">
                                <li class="list-group-item">
                                    <b>Вопросов</b> <a
                                        href="{{ route('user.questions', ['username' => $user->profile->username]) }}"
                                        class="float-right">{{ $user->questions_count }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Ответов</b> <a
                                        href="{{ route('user.answers', ['username' => $user->profile->username]) }}"
                                        class="float-right">{{ $user->answers_count }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Вклад</b> <a class="float-right">{{ $user->profile->rating }}</a>
                                </li>
                            </ul>
                        </div>
                        @auth()
                            @if(auth()->user()->id == $user->id)
                                <div class="card-footer">
                                    <a href="#" class="btn btn-block btn-default"><b>Редактировать</b></a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#info" data-toggle="tab">Информация</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#questions" data-toggle="tab">Вопросы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#answers" data-toggle="tab">Ответы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#comments" data-toggle="tab">Комментарии</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#subscriptions" data-toggle="tab">Подписки</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#likes" data-toggle="tab">Нравится</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="info">
                                    @if($user->profile->education)
                                        <strong><i class="fas fa-book mr-1"></i> Образование</strong>
                                        <p class="text-muted">
                                            {{ $user->profile->education }}
                                        </p>
                                        <hr>
                                    @elseif($user->profile->location)
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Местоположение</strong>
                                        <p class="text-muted">{{ $user->profile->location }}</p>
                                        <hr>
                                    @elseif($user->profile->skills)
                                        <strong><i class="fas fa-pencil-alt mr-1"></i> Навыки</strong>
                                        <p class="text-muted">
                                            {{ $user->profile->skills }}
                                        </p>
                                        <hr>
                                    @elseif($user->profile->about)
                                        <strong><i class="far fa-file-alt mr-1"></i> О себе</strong>
                                        <p class="text-muted">{{ $user->profile->about }}</p>
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователь пока ничего не рассказал о себе
                                        </h3>
                                    @endif
                                </div>

                                <div class="tab-pane" id="questions">
                                    @if($questions->count())
                                        @foreach($questions->sortByDesc('created_at') as $question)
                                            <x-question :question="$question"></x-question>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('user.questions', ['username' => $user->profile->username]) }}"
                                                   type="button" class="btn btn-block btn-outline-primary">Все вопросы
                                                    пользователя</a>
                                            </div>
                                        </div>
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователь не задал ни одного вопроса
                                        </h3>
                                    @endif
                                </div>

                                <div class="tab-pane" id="answers">
                                    @if($answers->count())
                                        @foreach( $answers->sortByDesc('created_at') as $answer )
                                            <x-answer :answer="$answer"></x-answer>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('user.answers', ['username' => $user->profile->username]) }}"
                                                   type="button" class="btn btn-block btn-outline-primary">Все ответы
                                                    пользователя</a>
                                            </div>
                                        </div>
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователь не ответил ни на один вопрос
                                        </h3>
                                    @endif
                                </div>

                                <div class="tab-pane" id="comments">
                                    @if(false)
                                        {{--  --}}
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователь не оставил ни одного комментария
                                        </h3>
                                    @endif
                                </div>
                                <div class="tab-pane" id="subscriptions">
                                    @if(false)
                                        {{--  --}}
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователь не подписан ни на один вопрос или тег
                                        </h3>
                                    @endif
                                </div>
                                <div class="tab-pane" id="likes">
                                    @if(false)
                                        {{--  --}}
                                    @else
                                        <h3 class="lead mt-2">
                                            Пользователю не понравился ни один ответ
                                        </h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
