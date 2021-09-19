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
                <ul class="tags-list ml-1">
                    @foreach($question->tags as $tag)
                        <li class="tags__list__item" style="margin-left: 47px;">
                            <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                               class="float-left">
                                {{ $tag->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <ul class="tags-list" >
                    @foreach($question->tags as $tag)
                        <li class="tags__list__item" style="margin-left: 47px;">
                            <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}"
                               class="float-left pl-1">
                                {{ $tag->title }}
                            </a>
                        </li>
                        @if ($loop->first)
                            <li class="tags__list__item gray"
                                title="{{ $question->tags->pluck('title')->slice(1)->join(', ') }}">
                                +{{ $loop->count - 1 }} ещё
                            </li>
                            @break
                        @endif
                    @endforeach
                </ul>
            @endif
            <div class="user-block mt-2 mb-0">
                <div class="row">
                    <div class="col-xl-10 col-md-10 col-sm-10">

                        <a href="{{route('question.show', ['id' => $question->id]) }}" class="question-link">
                            <img class="img-size-32"
                                 src="{{ asset($question->tags->first()->icon) }}"
                                 alt="{{ $question->tags->first()->title }}">
                            <span class="username">
                               <h4><b>{{ $question->title }}</b></h4>
                            </span>
                        </a>
                        <div class="description mt-0">
                            <span class="created_at"
                                  data-toggle="tooltip"
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
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-2 col-sm-2 float-right d-none d-sm-none d-md-flex">
                        <span>
                            @if($question->solutions->count())
                                <span>
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
        </div>
    </div>
    <div class="card-footer d-md-none d-lg-none">
        <a type="button"
           href="{{route('question.show', ['id' => $question->id]) }}"
           class="btn btn-default btn-flat btn-block">
            @if($question->solutions->count())
                <i class="fas fa-check text-success" data-toggle="tooltip" title="Есть решение"></i>
            @endif
            Ответов ({{ $question->answers_count }})
        </a>
    </div>
</div>
