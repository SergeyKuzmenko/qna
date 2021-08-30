@extends('layouts.app')
@section('title', 'Мои ответы')
@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Мои ответы ({{ $answers->total() }})</h1>
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
                    @if($answers->count() > 0)
                        @foreach( $answers->sortByDesc('created_at') as $answer )
                            <div class="card {{ $answer->is_solution ? 'card-outline card-success' : '' }}">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="post p-2">
                                            <div class="user-block">
                                                <a href="{{ $answer->question->user->profile->link }}">
                                                    <img class="img-circle img-bordered-sm"
                                                         src="{{ $answer->question->user->profile->avatar }}"
                                                         alt="{{ $answer->question->user->profile->full_name }}">
                                                </a>
                                                <span class="username">
                                              <a href="{{ route('question.show', ['id' => $answer->question->id]) }}">
                                                  {{ $answer->question->title }}</a>
                                            </span>
                                                <span
                                                    class="description">{{ Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}</span>
                                            </div>
                                            <div class="answer-body">
                                                {{ $answer->body }}
                                            </div>
                                        </div>
                                        <span class="float-right">
                                        <a href="{{ route('question.show', ['id' => $answer->question->id]) }}"
                                           class="link-black text-sm">
                                            <i class="far fa-comments mr-1"></i>
                                            Перейти к вопросу
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="lead mt-2">
                                        У Вас еще нет ответов
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="float-lg-right">
                        {{ $answers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
