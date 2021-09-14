@extends('layouts.app')
@section('title', $question->title)

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-default card-outline">
                <div class="card-body">
                    <div class="post">
                        <div class="ribbon-wrapper ribbon-lg">
                            @switch($question->complexity)
                                @case(1)
                                <div class="ribbon bg-success">Простой</div>
                                @break
                                @case(2)
                                <div class="ribbon bg-warning">Средний</div>
                                @break
                                @case(3)
                                <div class="ribbon bg-danger">Сложный</div>
                                @break
                            @endswitch
                        </div>
                        <div class="user-block">
                            <a href="{{ $question->user->profile->link }}">
                                <img class="img-circle img-bordered-sm"
                                     src="{{ $question->user->profile->avatar }}"
                                     alt="{{ $question->user->profile->full_name }}">
                            </a>
                            <a href="{{ $question->user->profile->link  }}">
                                <span class="username">
                                   {{ $question->user->profile->full_name }}
                                </span>
                            </a>
                            <span class="description">
                                <span class="created_at"
                                      title="Вопрос задан: {{ Carbon\Carbon::parse($question->created_at)->isoformat("D MMMM Y в H:m") }}"
                                >
                                    <i class="far fa-clock"></i>
                                    {{ Carbon\Carbon::parse($question->created_at)->diffForHumans() }}
                                </span>
                                <span class="views" title="Количество просмотров">
                                    &#8231; <i class="far fa-eye"></i> {{ $question->views }}
                                </span>
                            </span>
                        </div>
                        <p></p>
                        <h3 class="profile-username lead"><b>{{ $question->title }}</b></h3>
                        <p></p>
                        <div class="body-question mb-3">
                            {!! $question->body !!}
                        </div>
                        @foreach($question->tags as $tag)
                            <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                               class="link-black text-sm mr-2">
                                <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                                   class="float-left btn btn-sm">
                                    <img class="img-rounded img-size-32"
                                         src="{{ asset($tag->icon) }}"
                                         alt="{{ $tag->title }}">
                                    {{ $tag->title }}
                                </a>
                            </a>
                        @endforeach

                    </div>
                </div>
                <div class="card-footer">
                    @auth()
                        <subscribe-question-button
                            :question_id="{{ $question->id }}"
                            :is_subscribed="{{ ($question->is_subscribed) ? 'true' : 'false' }}"
                            :subscribers_count="{{ $question->count_subscribers }}">
                        </subscribe-question-button>
                        <button type="button" class="btn btn-outline-secondary float-left ml-2" data-toggle="modal"
                                data-target="#complexity">
                            <i class="fas fa-tachometer-alt"></i>
                            Сложность
                        </button>
                        @if($question->comments->count())
                            <button type="button" class="btn btn-default ml-2" data-toggle="collapse"
                                    data-target="#question-comments-{{ $question->id }}" aria-expanded="false"
                                    aria-controls="collapseExample">
                                <i class="far fa-comments mr-1"></i> {{ $question->comments->count() }}
                            </button>
                        @else
                            @auth()
                                <button type="button" class="btn btn-default ml-2" data-toggle="collapse"
                                        data-target="#question-comments-{{ $question->id }}" aria-expanded="false"
                                        aria-controls="collapseExample">
                                    <i class="far fa-comments"></i>
                                </button>
                            @endauth
                        @endif
                    @endauth
                    <div class="question-settings float-right">
                        <div class="dropdown dropleft">
                            <button class="btn btn-default btn-block"
                                    type="button"
                                    id="question-{{ $question->id }}-menu"
                                    data-toggle="dropdown"
                                    title="Управление вопросом"
                            >
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="question-{{ $question->id }}-menu">
                                <a class="dropdown-item" href="#who-subscribed-{{ $question->id }}">Кто подписался</a>
                                <a class="dropdown-item text-danger" href="#abuse-question-{{ $question->id }}">Пожаловаться</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if($question->comments->count())
                    <div class="comments-box collapse" id="question-comments-{{ $question->id }}">
                        @foreach($question->comments as $comment)
                            <div class="card-footer card-comments" style="padding-bottom: 0px; padding-top: 0px;">
                                <div class="card-comment border-top">
                                    <a href="{{ $comment->author->profile->link }}">
                                        <img class="img-circle img-sm mt-2" src="{{ $comment->author->profile->avatar }}"
                                             alt="{{ $comment->author->profile->full_name }}">
                                    </a>
                                    <div class="comment-text mt-2">
                                        <span class="username">
                                            <a href="{{ $comment->author->profile->link }}">{{ $comment->author->profile->full_name }}</a>
                                          <span
                                              class="text-muted float-right"
                                              title="Написано: {{ Carbon\Carbon::parse($comment->created_at)->isoformat("D MMMM Y в H:m") }}"
                                          >
                                              {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                          </span>
                                        </span>
                                        {{ $comment->text }}
                                    </div>
                                    <div class="comment-tool mt-2" style="margin-left: 40px;">
                                        <div class="btn-group btn-group-sm float-left mr-2 ">
                                            <button type="button" class="btn btn-outline-success btn-sm"><i class="far fa-heart"></i> Нравится</button>
                                            <button type="button" class="btn btn-outline-success btn-sm">0</button>
                                        </div>
                                        <button type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-share"></i> Ответить</button>
                                        <div class="comment-settings float-right">
                                            <div class="dropdown dropleft">
                                                <button class="btn btn-block btn-sm"
                                                        type="button"
                                                        id="comment-{{ $question->id }}-menu"
                                                        data-toggle="dropdown"
                                                        title="Управление комментарием"
                                                >
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="comment-{{ $comment->id }}-menu">
                                                    <a class="dropdown-item" href="#">Кому нравится</a>
                                                    <a class="dropdown-item text-danger" href="#">Пожаловаться</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @auth()
                            <div class="card-footer">
                                <form action="{{ route('comment.question.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                    <img class="img-fluid img-circle img-sm"
                                         src="{{ auth()->user()->profile->avatar }}"
                                         alt="{{ auth()->user()->profile->full_name }}">
                                    <div class="img-push">
                                        <comment-form type="question" :id="{{ $question->id }}"></comment-form>
                                    </div>
                                </form>
                            </div>
                        @endauth
                    </div>
                @else
                    @auth()
                        <div class="comments-box collapse" id="question-comments-{{ $question->id }}">
                            <div class="card-footer">
                                <form action="{{ route('comment.question.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                    <img class="img-fluid img-circle img-sm"
                                         src="{{ auth()->user()->profile->avatar }}"
                                         alt="{{ auth()->user()->profile->full_name }}">
                                    <div class="img-push">
                                        <comment-form type="question" :id="{{ $question->id }}"></comment-form>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </section>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 answers-box">
                    @foreach( $question->answers->sortByDesc('is_solution') as $answer )
                        <x-answer :answer="$answer"></x-answer>
                    @endforeach
                    <div class="answer-item new-answer" style="display: none;"></div>
                </div>
            </div>
            @auth()
                <answer-form :question_id="{{ $question->id }}" :answer_is_written="{{ ($question->answer_is_written) ? 'true' : 'false' }}"></answer-form>
            @endauth
        </div>
        @auth()
            <div class="modal fade" id="complexity" tabindex="-1" role="dialog" aria-labelledby="complexity"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="" method="get">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Оценить сложность вопроса</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="funkyradio">
                                            <div class="funkyradio-success">
                                                <input type="radio" value="1" name="complexity" id="radio-1"/>
                                                <label for="radio-1">Простой</label>
                                            </div>
                                            <div class="funkyradio-warning">
                                                <input type="radio" value="2" name="complexity" id="radio-2"/>
                                                <label for="radio-2">Средний</label>
                                            </div>
                                            <div class="funkyradio-danger">
                                                <input type="radio" value="3" name="complexity" id="radio-3"/>
                                                <label for="radio-3">Сложный</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Проголосовать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </section>
@endsection
