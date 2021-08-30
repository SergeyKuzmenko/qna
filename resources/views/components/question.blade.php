<div class="card question-item">
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
                         alt="{{ $question->user->profile->full_name }}"
                    >
                </a>
                <a href="{{route('question.show', ['id' => $question->id]) }}" class="question-link">
                    <span class="username">
                       {{ $question->title }}
                    </span>
                </a>
                <span
                    class="description">
                     {{ Carbon\Carbon::parse($question->created_at)->diffForHumans() }}
                    &#8231; {{ $question->views }} просмотров
                    &#8231; {{ rand(0,10) }} подписчиков
                </span>
            </div>
            <p class="mb-4">
                {{ Str::limit($question->body, 300) }}
            </p>

            @if(count($question->tags) == 1)
                @foreach($question->tags as $tag)
                    <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                       class="float-left btn btn-sm white">
                        <img class="img-rounded img-size-32"
                             src="{{ $tag->icon }}" alt="{{ $tag->title }}}">
                        {{ $tag->title }}
                    </a>
                @endforeach
            @else
                @foreach($question->tags as $tag)
                    <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                       class="float-left btn btn-sm white">
                        <img class="img-rounded img-size-32"
                             src="{{ $tag->icon }}" alt="{{ $tag->title }}}">
                        {{ $tag->title }}
                    </a>
                    @if ($loop->first)
                        <a class="btn white disabled">
                            +{{ $loop->count - 1 }} ещё
                        </a>
                        @break
                    @endif
                @endforeach
            @endif

            <span class="float-right">
                <span class="mr-1">
                    {!! ($question->hasSolutions) ? '<i class="fas fa-check text-success" data-toggle="tooltip" title="Есть решение"></i>' : '' !!}
                </span>
                <a href="{{route('question.show', ['id' => $question->id]) }}"
                   class="question-link {{ ($question->hasSolutions) ? 'text-success' : '' }}">
                    Ответов ({{ $question->answers_count }})
                </a>
            </span>
        </div>
    </div>
</div>
