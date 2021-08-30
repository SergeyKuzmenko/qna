@extends('layouts.app')
@section('title', 'Профиль')

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="float-left">{{ auth()->user()->profile->full_name }}</h1>
                    <a href="{{ route('logout') }}" class="btn btn-flat float-right">
                        <i class="fas fa-sign-out-alt"></i> Выход
                    </a>
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
                                     src="{{ $user['profile']['avatar'] }}">
                            </div>

                            <h3 class="profile-username text-center">{{ $user['profile']['full_name'] }}</h3>

                            <p class="text-muted text-center">{{ $user['profile']['full_name'] }}</p>

                            <ul class="list-group list-group-unbordered mb-1">
                                <li class="list-group-item">
                                    <b>Вопросов</b> <a
                                        href="{{ route('user.questions', ['username' => $user['profile']['username']]) }}"
                                        class="float-right">{{ $user['questions_count'] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Ответов</b> <a
                                        href="{{ route('user.answers', ['username' => $user['profile']['username']]) }}"
                                        class="float-right">{{ $user['answers_count'] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Вклад</b> <a class="float-right">{{ $user['profile']['rating'] }}</a>
                                </li>
                            </ul>
                        </div>
                        @auth()
                            @if(auth()->user()->id == $user['profile']['id'])
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
                                <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Информация</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#questions" data-toggle="tab">Вопросы</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#answers" data-toggle="tab">Ответы</a>
                                </li>
                                {{--                                <li class="nav-item"><a class="nav-link" href="#comments" data-toggle="tab">Комментарии</a></li>--}}
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="info">
                                    <strong><i class="fas fa-book mr-1"></i> Образование</strong>
                                    <p class="text-muted">
                                        B.S. in Computer Science from the University of Tennessee at Knoxville
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Местоположение</strong>
                                    <p class="text-muted">Malibu, California</p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Навыки</strong>
                                    <p class="text-muted">
                                        Design, Coding, Javascript, PHP, Node.js
                                    </p>
                                    <hr>
                                    <strong><i class="far fa-file-alt mr-1"></i> О себе</strong>
                                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                        fermentum enim neque.</p>
                                </div>

                                <div class="tab-pane" id="questions">
                                    @foreach($user['last_questions'] as $question)
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{ $user['profile']['avatar'] }}"
                                                     alt="{{ $user['profile']['full_name'] }}">

                                                <span class="username">
                                                <a href="{{ route('question.show', ['id' => $question['id']]) }}">{{ $question['title'] }}</a>
                                            </span>
                                                <span class="description">{{ $question['created_at'] }}</span>
                                            </div>
                                            <p class="mb-4">
                                                {{ Str::limit($question['body'], 200) }}
                                            </p>

                                            @foreach($question['tags'] as $tag)
                                                <a href="{{ route('tag.info', ['slug' => $tag['slug']]) }}"
                                                   class="link-black text-sm mr-2">
                                                    <a href="{{ route('tag.info', ['slug' => $tag['slug']]) }}"
                                                       class="float-left btn-tool">
                                                        <img class="img-rounded img-size-32"
                                                             src="{{ $tag['icon'] }}"
                                                             alt="{{ $tag['title'] }}">
                                                        {{ $tag['title'] }}
                                                    </a>
                                                </a>
                                            @endforeach

                                            <span class="float-right">
                                            <a href="{{ route('question.show', ['id' => $question['id']]) }}"
                                               class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Ответов ({{ $question['answers_count'] }})
                                            </a>
                                        </span>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('user.questions', ['username' => $user['profile']['username']]) }}" type="button" class="btn btn-block btn-outline-primary">Все вопросы пользователя</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="answers">
                                    @foreach( $user['last_answers'] as $answer )
                                        <div class="card {{ $answer['is_solution'] ? 'card-outline card-success' : '' }}">
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="post p-2">
                                                        <div class="user-block">
                                                            <a href="{{ $user['profile']['link'] }}">
                                                                <img class="img-circle img-bordered-sm"
                                                                     src="{{ $user['profile']['avatar'] }}"
                                                                     alt="{{ $user['profile']['full_name'] }}">
                                                            </a>
                                                            <span class="username">
                                                              <a href="{{ route('question.show', ['id' => $answer['question_id']]) }}">
                                                                  {{ $answer['question']['title'] }}</a>
                                                            </span>
                                                            <span class="description">{{ $answer['created_at'] }}</span>
                                                        </div>
                                                        <div class="answer-body">
                                                            {{ $answer['body'] }}
                                                        </div>
                                                    </div>
                                                    <span class="float-right">
                                                        <a href="{{ route('question.show', ['id' => $answer['question']['id']]) }}" class="link-black text-sm">
                                                            <i class="far fa-comments mr-1"></i>
                                                            Перейти к вопросу
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('user.answers', ['username' => $user['profile']['username']]) }}" type="button" class="btn btn-block btn-outline-primary">Все ответы пользователя</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="comments">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName"
                                                       placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                       placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience"
                                                   class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience"
                                                          placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                       placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
