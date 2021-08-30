<div class="text-center card-box tag-item {{ (session('dark_mode')) ? 'dark-mode border' : '' }}">
    <div class="member-card pt-2 pb-2">
        <div class="thumb-lg member-thumb mx-auto">
            <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}">
                <img src="{{ $tag->icon }}" class="img-rounded w-100"
                     alt="{{ $tag->title }}">
            </a>
        </div>
        <div class="mt-2">
            <h4>
                <a href="{{ route('tag.info', ['slug' => $tag->slug]) }}">{{ $tag->title }}</a>
            </h4>
        </div>
        <div class="mt-4">
            <div class="row">
                <div class="col-6">
                    <div class="mt-0">
                        <h4>
                            <a href="{{ route('tag.questions', ['slug' => $tag->slug]) }}">{{ $tag->questions_count }}</a>
                        </h4>
                        <p class="mb-0 text-muted">Вопросы</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mt-0">
                        <h4>
                            <a href="{{ route('tag.followers', ['slug' => $tag->slug]) }}">{{ $tag->followers_count }}</a>
                        </h4>
                        <p class="mb-0 text-muted">Подписчики</p>
                    </div>
                </div>
            </div>
        </div>
        @auth()
            @if(!$tag->is_follow)
                <a type="button" href="{{ route('tag.subscribe', ['slug' => $tag->slug]) }}"
                   class="btn btn-block btn-outline-success btn-sm mt-2">
                    Подписаться
                </a>
            @else
                <a type="button" href="{{ route('tag.unsubscribe', ['slug' => $tag->slug]) }}"
                   class="btn btn-block btn-outline-danger btn-sm mt-2">
                    Отписаться
                </a>
            @endif
        @endauth
    </div>
</div>
