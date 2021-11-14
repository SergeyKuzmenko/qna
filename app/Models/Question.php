<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Question extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var array[]
     */
    protected $fillable = ['title', 'body', 'user_id', 'complexity'];
    /**
     * @var array[]
     */
    protected $with = ['user.profile', 'tags', 'answers', 'comments', 'answers.user', 'solutions'];

    /**
     * @var array[]
     */
    protected $withCount = ['answers', 'subscribers'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Answer::class)->where('is_solution', true);
    }

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->when(auth()->user(), function ($query) {
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }]);
        });
    }

    /**
     * @return bool
     */
    public function getAnswerIsWrittenAttribute()
    {
        return !!$this->answers()->where('user_id', auth()->id())->count();
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->when(auth()->user(), function ($query) {
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }]);
        });
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByInteresting()
    {
        // todo...
        return $this->getAllQuestionsByNew();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByNew()
    {
        return $this
            ->without(['answers', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByWithoutAnswers()
    {
        return $this
            ->doesntHave('answers')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByDefault()
    {
        return $this->getAllQuestionsByNew();
    }

    /**
     * @param $tag
     * @param string $by
     * @return LengthAwarePaginator
     */
    public function getQuestionsByTag($tag, $by = 'new')
    {
        return self::whereHas('tags', function ($query) use ($tag) {
            $query->whereIn('tags.id', $tag);
        })
            ->withCount('answers')
            ->with(['user.profile', 'tags'])
            ->when($by === 'new', function ($query) {
                $query->orderBy('created_at');
            })
            ->when($by === 'interesting', function ($query) {
                $query->orderBy('created_at');
            })
            ->when($by === 'without_answers', function ($query) {
                $query->doesntHave('answers');
            })->paginate(20);
    }

    /**
     * @param $request
     * @return Question|Model
     */
    public function newQuestion($request)
    {
        $question = Question::query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'complexity' => $request->complexity
        ]);
        if ($question) {
            $question->tags()->attach($request->tags);
            $question->subscribe();
        }
        return $question;
    }

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    /**
     * @return array
     */
    public function subscribe()
    {
        return $this->subscribers()->syncWithoutDetaching(auth()->id());
    }

    /**
     * @return BelongsToMany
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'question_subscriber');
    }

    /**
     * @return int
     */
    public function unsubscribe()
    {
        return $this->subscribers()->detach(auth()->id());
    }

    /**
     * @return bool
     */
    public function getIsSubscribedAttribute()
    {
        return !!$this->subscribers()->whereIn('user_id', [auth()->id()])->count();
    }

    /**
     * @return int
     */
    public function getCountSubscribersAttribute()
    {
        return $this->subscribers()->count();
    }
}
