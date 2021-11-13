<div class="comment-item">
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
                {!! $comment->text !!}
            </div>
            <div class="comment-tool mt-2" style="margin-left: 40px;">
                <like-button
                    target_type="comment"
                    target_id="{{ $comment->id }}"
                    :is_liked="{{ ($comment->is_liked) ? 'true' : 'false' }}"
                    :likes_count="{{ $comment->likeCount }}">
                </like-button>
                @auth()
                    <button type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-share"></i> Ответить</button>
                @endauth()
                <div class="comment-settings float-right">
                    <div class="dropdown dropleft">
                        <button class="btn btn-block btn-sm"
                                type="button"
                                id="comment-{{ $comment->id }}-menu"
                                data-toggle="dropdown"
                                title="Управление комментарием"
                        >
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="comment-{{ $comment->id }}-menu">
                            @auth()
                                @if(auth()->user()->id === $comment->user_id)
                                    <a class="dropdown-item" href="#edit-{{ $comment->id }}">Редактировать</a>
                                    <a class="dropdown-item text-danger" href="#delete-answer-{{ $comment->id }}">Удалить</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                            @endauth
                            <a class="dropdown-item text-danger" href="#abuse-comment-{{ $comment->id }}">Пожаловаться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
