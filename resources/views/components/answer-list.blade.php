<div class="card answer-item {{ $answer->is_solution ? 'card-outline card-success' : '' }}">
    <div class="card-body">
        <div class="tab-content">
            <div class="post p-2">
                <div class="user-block">
                    <a href="{{ $answer->user->profile->link }}">
                        <img class="img-circle img-bordered-sm"
                             src="{{ $answer->user->profile->avatar }}"
                             alt="{{ $answer->user->profile->full_name }}"
                        >
                    </a>
                    <span class="username">
                      <a href="{{ route('question.show', ['id' => $answer->question->id]) }}">
                          {{ $answer->question->title }}</a>
                        @if($answer->is_solution)
                            <div class="ribbon-wrapper">
                                <i class="fas fa-check text-success float-right mt-3 mr-3"
                                   data-toggle="tooltip" title="Отмечено решением"></i>
                            </div>
                        @endif
                    </span>
                    <span class="description">
                        {{ Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}
                    </span>
                </div>
                <div class="answer-body">
                    {{ $answer->body }}
                </div>
            </div>
            <span class="float-right">
                <a href="{{ route('question.show', ['id' => $answer->question->id]) }}"
                   class="question-link">
                    <i class="far fa-comments mr-1"></i>
                    Перейти к вопросу
                </a>
            </span>
        </div>
    </div>
</div>
