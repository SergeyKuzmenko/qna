@extends('layouts.app')
@section('title', $question->title)

@section('content-header')
    {{ $question->comments->dump() }}
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
                            <span
                                class="description">{{ Carbon\Carbon::parse($question->created_at)->diffForHumans() }}</span>
                        </div>
                        <p>
                        <h3 class="profile-username lead"><b>{{ $question->title }}</b></h3>
                        </p>
                        <div class="body-question mb-3">
                            {{ $question->body }}
                        </div>
                        @foreach($question['tags'] as $tag)
                            <a href="{{ route('tag.info', ['slug' => $tag['slug']]) }}"
                               class="link-black text-sm mr-2">
                                <a href="{{ route('tag.info', ['slug' => $tag['slug']]) }}"
                                   class="float-left btn btn-sm">
                                    <img class="img-rounded img-size-32"
                                         src="{{ $tag['icon'] }}"
                                         alt="{{ $tag['title'] }}">
                                    {{ $tag['title'] }}
                                </a>
                            </a>
                        @endforeach

                    </div>
                </div>
                <div class="card-footer">
                    @auth()
                        <button type="button" class="btn btn-outline-primary float-left"><i class="fa fa-bell"></i>
                            Подписаться
                        </button>

                        <button type="button" class="btn btn-default float-left ml-2" data-toggle="modal"
                                data-target="#complexity">
                            <i class="fas fa-tachometer-alt"></i>
                            Сложность вопроса
                        </button>

                        <div class="btn-group float-right">
                            <span class="mt-2">
                                <i class="far fa-eye" data-toggle="tooltip" title="Просмотров"></i> {{ $question->views }}
                            </span>
                        </div>
                    @endauth
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
                    @foreach( $question->answers->sortByDesc('is_solution') as $answer )
                        <div class="card {{ $answer->is_solution ? 'card-outline card-success' : '' }}">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="post p-2">
                                        <div class="user-block">
                                            <a href="{{ $answer->user->profile->link }}">
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{ $answer->user->profile->avatar }}"
                                                     alt="{{ $answer->user->profile->full_name }}">
                                            </a>
                                            <span class="username">
                                                <a href="{{ $answer->user->profile->link }}">{{ $answer->user->profile->full_name }}</a>
                                                @if($answer->is_solution)
                                                    <div class="ribbon-wrapper">
                                                        <i class="fas fa-check text-success float-right mt-3 mr-3"
                                                           data-toggle="tooltip" title="Отмечено решением"></i>
                                                    </div>
                                                @endif
                                            </span>
                                            <span
                                                class="description">{{ Carbon\Carbon::parse($question->created_at)->diffForHumans() }}</span>
                                        </div>
                                        <div class="answer-body">
                                            {{ $answer->body }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @auth()
                                <div class="card-footer">
                                    <div class="btn-group float-left">
                                        <button type="button" class="btn btn-default">
                                            <i class="far fa-heart"></i> Нравится
                                        </button>
                                        <button type="button" class="btn btn-default">
                                            0
                                        </button>
                                    </div>
                                    <div class="btn-group float-right">
                                        <button type="button" class="btn btn-outline-danger btn-block btn-sm">
                                            <i class="far fa-flag"></i>
                                        </button>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
            @auth()
                @include('layouts.sections.answer-form')
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
