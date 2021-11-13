<div class="answer-item" id="answer-{{ $answer->id }}">
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
            <like-button
                target_type="answer"
                target_id="{{ $answer->id }}"
                :is_liked="{{ ($answer->is_liked) ? 'true' : 'false' }}"
                :likes_count="{{ $answer->likeCount }}">
            </like-button>
            @if($answer->comments->count())
                <button type="button" class="btn btn-default float-left ml-2"
                        data-toggle="collapse" data-target="#answer-comments-{{ $answer->id }}"
                        aria-expanded="false" aria-controls="answer-comments-{{ $answer->id }}">
                    <i class="far fa-comments"></i> {{ $answer->comments->count() }}
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
                    @auth()
                        @if(auth()->user()->id === $answer->user_id)
                            <button class="dropdown-item">Редактировать</button>
                            <button class="dropdown-item text-danger" @click="deleteAnswer({{ $answer->id }})">Удалить</button>
                            <div class="dropdown-divider"></div>
                        @endif
                    @endauth
                    <button class="dropdown-item text-danger">Пожаловаться</button>
                </div>
            </div>
        </div>
        @if($answer->comments->count())
            <div class="comments-box collapse" id="answer-comments-{{ $answer->id }}">
                @foreach($answer->comments as $comment)
                    <x-comment :comment="$comment"></x-comment>
                @endforeach
                <div class="card-footer">
                    @auth()
                        <img class="img-fluid img-circle img-sm"
                             src="{{ auth()->user()->profile->avatar }}"
                             alt="{{ auth()->user()->profile->full_name }}">
                        <div class="img-push">
                            <comment-form type="answer" :id="{{ $answer->id }}"></comment-form>
                        </div>
                    @endauth
                </div>
            </div>
        @else
            <div class="comments-box collapse" id="answer-comments-{{ $answer->id }}">
                <div class="card-footer">
                    @auth()
                        <img class="img-fluid img-circle img-sm"
                             src="{{ auth()->user()->profile->avatar }}"
                             alt="{{ auth()->user()->profile->full_name }}">
                        <div class="img-push">
                            <comment-form type="answer" :id="{{ $answer->id }}"></comment-form>
                        </div>
                    @endauth
                </div>
            </div>
        @endif
    </div>
</div>
