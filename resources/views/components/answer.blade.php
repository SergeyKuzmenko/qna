<div class="answer-item">
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
                        <span class="description"
                            title="Дата публикации: {{ Carbon\Carbon::parse($answer->created_at)->isoformat("D MMMM Y в H:m") }}"
                        >
                            {{ Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}
                        </span>
                    </div>
                    <div class="answer-body">
                        {!! $answer->body !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            @auth()
                <like-button :answer_id="{{ $answer->id }}"
                             :is_liked="{{ ($answer->is_liked) ? 'true' : 'false' }}"
                             :likes_count="{{ $answer->likeCount }}"></like-button>
            @endauth

            @if($answer->comments->count() > 0)
                <button type="button" class="btn btn-link float-left ml-2"
                        data-toggle="collapse" data-target="#answer-comments-{{ $answer->id }}"
                        aria-expanded="false" aria-controls="answer-comments-{{ $answer->id }}">
                    Комментариев ({{ $answer->comments->count() }})
                </button>
            @else
                @auth()
                    <button type="button" class="btn btn-default float-left ml-2"
                            data-toggle="collapse" data-target="#answer-comments-{{ $answer->id }}"
                            aria-expanded="false" aria-controls="answer-comments-{{ $answer->id }}">
                        <i class="far fa-comments"></i>
                    </button>
                @endauth
            @endif
            @auth()
                <div class="dropdown float-right dropleft">
                    <button class="btn btn-default btn-block"
                            type="button"
                            id="answer-{{ $answer->id }}-menu"
                            data-toggle="dropdown"
                            title="Управление ответом"
                    >
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="answer-{{ $answer->id }}-menu">
                        <a class="dropdown-item" href="#who-liked-{{ $answer->id }}">Кому понравилось</a>
                        <a class="dropdown-item text-danger" href="#abuse-answer-{{ $answer->id }}">Пожаловаться</a>
                    </div>
                </div>
            @endauth
        </div>
        @if($answer->comments->count())
            <div class="comments-box collapse" id="answer-comments-{{ $answer->id }}">
                @foreach($answer->comments as $comment)
                    <div class="card-footer card-comments">
                        <div class="card-comment">
                            <a href="{{ $comment->author->profile->link }}">
                                <img class="img-circle img-sm"
                                     src="{{ $comment->author->profile->avatar }}"
                                     alt="{{ $comment->author->profile->full_name }}">
                            </a>
                            <div class="comment-text">
                                        <span class="username">
                                            <a href="{{ $comment->author->profile->link }}">{{ $comment->author->profile->full_name }}</a>
                                          <span
                                              class="text-muted float-right">
                                              {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                          </span>
                                        </span>
                                {{ $comment->text }}
                            </div>
                        </div>
                    </div>
                @endforeach
                @auth()
                        <comment-form type="answer" id="{{ $answer->id }}"></comment-form>
                @endauth
            </div>
        @else
            @auth()
                <div class="comments-box collapse" id="answer-comments-{{ $answer->id }}">
                    <div class="card-footer">
                        <form action="#" method="post" onsubmit="return false;">
                            <img class="img-fluid img-circle img-sm"
                                 src="{{ auth()->user()->profile->avatar }}" alt="{{ auth()->user()->profile->full_name }}">
                            <div class="img-push">
                                <comment-form type="answer" id="{{ $answer->id }}"></comment-form>
                            </div>
                        </form>
                    </div>
                </div>
            @endauth
        @endif
    </div>
</div>
