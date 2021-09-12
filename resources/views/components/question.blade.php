<div class="card question-item">
    <div class="card-body">
        <div class="post">
            <div class="ribbon-wrapper ribbon-sm">
                @switch($question->complexity)
                    @case(1)
                    <div class="ribbon bg-success"></div>
                    @break
                    @case(2)
                    <div class="ribbon bg-warning"></div>
                    @break
                    @case(3)
                    <div class="ribbon bg-danger"></div>
                    @break
                @endswitch
            </div>
            @if(count($question->tags) == 1)
                @foreach($question->tags as $tag)
                    <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                       class="float-left btn btn-sm white">
                        <img class="img-rounded img-size-32"
                             src="{{ asset($tag->icon) }}" alt="{{ $tag->title }}}">
                        {{ $tag->title }}
                    </a>
                @endforeach
            @else
                <ul class="tags-list">
                @foreach($question->tags as $tag)
                    <li class="tags__list__item">
                        <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                           class="float-left pl-1">
                            <img class="img-rounded tag_list_item_icon"
                                 src="{{ asset($tag->icon) }}" alt="{{ $tag->title }}}">
                            {{ $tag->title }}
                        </a>
                    </li>
                    @if ($loop->first)
                        <li class="tags__list__item gray">
                            +{{ $loop->count - 1 }} ещё
                        </li>
                        @break
                    @endif
                @endforeach
                </ul>
            @endif
            <div class="user-block">
                <a href="{{ $question->user->profile->link }}">
                    <img class="img-circle img-bordered-sm"
                         src="{{ $question->user->profile->avatar }}"
                         alt="{{ $question->user->profile->full_name }}"
                    >
                </a>
                <a href="{{route('question.show', ['id' => $question->id]) }}" class="question-link">
                    <span class="username">
                       {{ $question->title }}
                    </span>
                </a>
                <span class="description">
                    <span class="created_at" data-toggle="tooltip"
                          title="{{ Carbon\Carbon::parse($question->created_at)->isoformat("D MMMM Y в H:m") }}">
                        <i class="far fa-clock"></i>
                        {{ Carbon\Carbon::parse($question->created_at)->diffForHumans() }}
                    </span>
                    <span class="views" data-toggle="tooltip" title="Просмотры">
                        &#8231; <i class="far fa-eye"></i> {{ $question->views }}
                    </span>
                    <span class="subscribers_count" data-toggle="tooltip" title="Подписчики">
                        &#8231; <i class="fas fa-user-friends"></i> {{ $question->subscribers_count }}
                    </span>
                </span>
            </div>

            <span class="float-right mt-2">
                @if($question->solutions->count())
                    <span class="mr-1">
                    <i class="fas fa-check text-success" data-toggle="tooltip" title="Есть решение"></i>
                </span>
                @endif
                <a href="{{route('question.show', ['id' => $question->id]) }}"
                   class="question-link {{ $question->solutions->count() ? 'text-success' : '' }}">
                    Ответов ({{ $question->answers_count }})
                </a>
            </span>
        </div>
    </div>
</div>
